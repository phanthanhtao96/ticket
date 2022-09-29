<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificationsController;
use App\Models\Data;
use App\Models\Request;
use App\Models\Tool;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RequestsUpUrgencyLevel extends Command
{
    protected $signature = 'cron:requests_up_level';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        Request::join('sla', 'requests.sla_id', 'sla.id')
            ->join('users', 'requests.request_by', 'users.id')
            ->join('users as tech', 'requests.technician_id', 'tech.id')
            ->where('requests.overdue_status', 0)
            ->select(
                'requests.*',
                'sla.max_response_time',
                'sla.max_resolve_time',
                'sla.enable_levels',
                'sla.time_to_l2',
                'sla.time_to_l3',
                'sla.time_to_l4',
                'sla.l2_data',
                'sla.l3_data',
                'sla.l4_data',
                'sla.response_data',
                'users.name as requester_name',
                'tech.name as tech_name',
                'tech.email as tech_email'
            )
            ->where([
                ['requests.active_date', '!=', null],
                ['requests.due_by_date', '>', $now]
            ])
            ->whereIn('requests.status', ['Open', 'Answered', 'CustomerReply'])
            ->chunkById(1, function ($requests) use ($now) {
                foreach ($requests as $request):

                    //Active minutes
                    $start = Carbon::parse($request->active_date);
                    $end = Carbon::parse($now);
                    $activeMinutes = $end->diffInMinutes($start);
                    $this->info($activeMinutes);
                    //Enable levels
                    $enableLevels = json_decode($request->enable_levels, true);

                    foreach (Data::$slaLevels as $slaLevelKey => $slaLevel):
                        if (in_array($slaLevelKey, $enableLevels)):

                            $slaRules = json_decode($request[$slaLevel['data_column']], true);

                            //Rules
                            if (count($slaRules) > 0):
                                foreach ($slaRules as $slaRuleKey => $slaRule):

                                    //Check has notify
                                    $checkHasNotifyByKey = (new NotificationsController())->checkHasNotifyByKey('Request', $request->id, $slaRuleKey);
                                    //If not
                                    if (!$checkHasNotifyByKey) {

                                        //Get involvement
                                        $userIds = [];
                                        $userEmails = [];
                                        if (isset($slaRule['role_type']) && $slaRule['role_type'] !== 'Undefined') {
                                            $users = (new User())->getAllUsersInvolve($request->technician_id, $request->technicians, $request->request_by, $request->followers);
                                            $userIds = $users[0];
                                            $userEmails = $users[1];
                                        }

                                        //Response rules not have time_column
                                        $escalateTime = $request[$slaLevel['time_column']] ?? 0;
                                        if ($slaLevel['data_column'] == 'response_data'){
                                            $escalateTime = $request['max_response_time'] + $slaRule['difference_time'] + $escalateTime;
                                        } else {
                                            $escalateTime = $request['max_resolve_time'] + $slaRule['difference_time'] + $escalateTime;
                                        }

                                        //Check time
                                        $sendNotify = false;
                                        switch ($slaRule['time_type']):
                                            case 'Before':
                                                if ($activeMinutes + $slaRule['difference_time'] >= $escalateTime)
                                                    $sendNotify = true;
                                                break;
                                            case 'Equal':
                                            case 'After':
                                                if ($activeMinutes >= $escalateTime)
                                                    $sendNotify = true;
                                                break;
                                        endswitch;

                                        if ($sendNotify) {

                                            //Email type, Notify content
                                            $sendToList = [];
                                            $ccList = [];
                                            $notify = '';
                                            $emailVars = [
                                                'ticket_id' => $request->id,
                                                'ticket_name' => $request->name,
                                                'ticket_url' => env('APP_URL') . '/requests/request/' . $request->id,
                                                'technician_name' => $request->tech_name,
                                                'sd_name' => $request->requester_name
                                            ];
                                            $sendToList[] = $request->tech_email;

                                            switch ($slaRule['email_type']):
                                                case 'BeforeEscalateEmail':
                                                    $notify = 'Nhắc nhở sắp đến hạn chuyển cấp: Request ' . Tool::getTicketFullName($request->id, $request->name) . ' ' .
                                                        'còn ' . Tool::calcMinutesToDays((int)$request[$slaLevel['time_column']] - $activeMinutes) . ' để chuyển lên cấp cao hơn';
                                                    break;
                                                case 'EscalateEmail':
                                                    //Get technician next level
                                                    $upLevel = $slaLevelKey; //Next level
                                                    $technicians = (new User())->getArrUsersByRole(0, $slaRule['role_type'], $request->company_id, $request->group_id, $request->site, true);

                                                    $updateData = [
                                                        'level' => $upLevel
                                                    ];

                                                    if (isset($technicians[0][0])) {
                                                        //Assign new technician
                                                        $updateData['technician_id'] = $technicians[0][0]; //Technician id
                                                        //Move old technician
                                                        $oldTechnicians = $request->technicians;
                                                        $oldTechnicians[] = (string)$request->technician_id;
                                                        $updateData['technicians'] = $oldTechnicians;

                                                        $emailVars['technician_name'] = $technicians[2][0]; //Technician name
                                                        $emailVars['ticket_due_by_date'] = Carbon::parse($request->due_by_date)->format('H:i d/m/Y');
                                                        $emailVars['ticket_url'] = '<a href="' . $emailVars['ticket_url'] . '" target="_blank">' . $emailVars['ticket_url'] . '</a>';

                                                        $sendToList[] = $technicians[1][0]; //Technician email. send to new technician
                                                    }

                                                    $notify = 'Thông báo chuyển cấp level ' . $upLevel . ': Request ' . Tool::getTicketFullName($request->id, $request->name) . ' được chuyển lên cấp cao hơn';

                                                    if ($request->level < $upLevel) {
                                                        (new Request())->where('id', $request->id)->update($updateData);
                                                    }

                                                    break;
                                                case 'AfterEscalateEmail':
                                                    $notify = 'Cảnh báo chuyển cấp: Request ' . Tool::getTicketFullName($request->id, $request->name) . ' đã chuyển lên cấp cao hơn';
                                                    break;
                                                case 'ResponseReminderEmail':
                                                    $notify = 'Nhắc nhở sắp đến hạn phản hồi: Request ' . Tool::getTicketFullName($request->id, $request->name);
                                                    break;
                                                case 'ResponseLateEmail':
                                                    $notify = 'Cảnh báo phản hồi chậm: Request ' . Tool::getTicketFullName($request->id, $request->name) . ' ' .
                                                        'đã ' . Tool::calcMinutesToDays($activeMinutes) . ' không được phản hồi từ kỹ thuật phụ trách';
                                                    break;
                                                case 'ResolveReminderEmail':
                                                    $notify = 'Nhắc nhở sắp đến hạn giải quyết: Request ' . Tool::getTicketFullName($request->id, $request->name);
                                                    break;
                                                case 'ResolveLateEmail':
                                                    $notify = 'Cảnh báo giải quyết chậm: Request ' . Tool::getTicketFullName($request->id, $request->name) . ' ' .
                                                        'đã ' . Tool::calcMinutesToDays($activeMinutes) . ' không được giải quết từ kỹ thuật phụ trách';
                                                    break;
                                            endswitch;

                                            //SLA rule cc user involvement and request user involvement
                                            $slaUsers = (new User())->getAllUserByEmailTags($slaRule['cc'], $request->company_id, 0);
;
                                            $slaUserIds = $slaUsers[0];
                                            $slaUserEmails = $slaUsers[1];
                                            $allUserIds = array_values(array_unique(array_merge($userIds, $slaUserIds)));
                                            $allUserEmails = array_values(array_unique(array_merge($userEmails, $slaUserEmails)));

                                            //Send Notification
                                            (new NotificationsController())->addNotification(
                                                'Request',
                                                1,
                                                $request->id,
                                                $notify,
                                                env('APP_URL') . '/requests/request/' . $request->id,
                                                $allUserIds,
                                                $allUserEmails,
                                                '',
                                                $slaRuleKey,
                                                ''
                                            );

                                            //Send email
                                            $ccList = array_values(array_unique(array_merge($ccList, $allUserEmails)));
                                            (new MailController())->createMail(
                                                $slaRule['email_type'],
                                                $emailVars,
                                                env('MAIL_FROM_ADDRESS'),
                                                $sendToList,
                                                $ccList,
                                                []
                                            );

                                        }
                                    }
                                endforeach;
                            endif;
                        endif;
                    endforeach;
                endforeach;

            }, 'requests.id', 'id');
    }
}
