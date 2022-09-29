<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Change;
use App\Models\Client;
use App\Models\Company;
use App\Models\Data;
use App\Models\Department;
use App\Models\Email;
use App\Models\Group;
use App\Models\Notification;
use App\Models\Priority;
use App\Models\Rating;
use App\Models\Reply;
use App\Models\Role;
use App\Models\SLA;
use App\Models\Solution;
use App\Models\Tool;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Push;

class RequestsController extends Controller
{
    public function getUndefinedList()
    {
        $currentUser = Auth::user();
        $role = Role::query()->find($currentUser->role_id);
        $conditions[] = ['active_date', null];

        if ($role && in_array($role->type, ['TechnicianL1', 'TechnicianL2'])) {
            $conditions[] = ['requests.technician_id', $currentUser->id];
        }
        $requests = ClientRequest::where($conditions)
            ->select('id', 'name', 'client_email', 'created_at')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(Data::$perPage);
        return view('layouts.requests.undefined-list')->with(['requests' => $requests]);
    }

    public function getRequests($filter = 'none', $filter_value = 'none', $status = '')
    {
        $currentUser = Auth::user();
        $role = Role::query()->find($currentUser->role_id);
        $conditions = [];

        if ($role && in_array($role->type, ['TechnicianL1', 'TechnicianL2'])) {
            $conditions[] = ['requests.technician_id', $currentUser->id];
        }

        if ($filter != 'none' && $filter_value != 'none') {
            $filter_value = str_replace('+', ' ', $filter_value);
            $column = Schema::hasColumn('requests', $filter) ? $filter : 'name';
            if ($column == 'id') $conditions = [['requests.id', $filter_value]];
            else $conditions = [['requests.' . $column, 'LIKE', '%' . $filter_value . '%']];
        }

        $requests = ClientRequest::join('priorities', 'requests.priority_id', 'priorities.id')
            ->join('users', 'requests.request_by', 'users.id')
            ->join('users as tech', 'requests.technician_id', 'tech.id')
            ->where($conditions)
            ->where('requests.active_date', '!=', null)
            ->whereNotIn('requests.status', ['Draft'])
            ->when($status, function ($query, $status) {
                $statusArr = explode('+', $status);
                if ($status != '')
                    $query->whereIn('requests.status', $statusArr);
            })
            ->orderBy('requests.flag', 'desc')
            ->orderBy('requests.created_at', 'desc')
            ->orderBy('requests.hidden', 'asc')
            ->orderBy('priorities.level', 'desc')
            ->orderBy('requests.id', 'desc')
            ->select(
                'requests.*',
                'priorities.name as priority_name',
                'priorities.level as priority_level',
                'users.id as requester_id',
                'users.name as requester_name',
                'tech.id as technician_id',
                'tech.name as technician_name'
            )
            ->paginate(Data::$perPage);

        $categories = Category::where('type', 'Default')
            ->orderBy('name', 'ASC')
            ->get();

        return view('layouts.requests.requests')->with([
            'categories' => $categories,
            'requests' => $requests,
            'filter' => $filter,
            'filter_value' => $filter_value,
            'status' => $status
        ]);
    }

    public function postRequests(Request $request)
    {
        $filter = $request->filter ?? 'name';
        $filter_value = $request->filter_value ?? '';
        $status = $request->status ?? '';
        $filter_value = str_replace(' ', '+', $filter_value);
        return redirect()->to('/requests/list/' . $filter . '/' . $filter_value . '/' . $status);
    }

    public function getRequest($id = 0, $option = '')
    {
        $request = (object)[
            'uuid' => '',
            'rel_id' => '',
            'type' => '',
            'site' => '',
            'mode' => '',
            'so' => '',
            'so_status' => '',
            'tac' => '',
            'flag' => 0,
            'solutions' => [],
            'technician_id' => 0,
            'client_id' => 0,
            'invoice_id' => 0,
            'category_id' => 0,
            'company_id' => 0,
            'group_id' => 0,
            'client_email' => '',
            'request_by' => 0,
            'sla_id' => 0,
            'priority_id' => 0,
            'status' => 'Open',
            'name' => '',
            'root_cause' => '',
            'content' => '',
            'attachments' => [],
            'hidden' => 0,

            'part_device' => '',
            'serial_number' => '',
            'tracking_number' => '',

            'rma_doa' => '',

            'active_date' => null,
            'due_by_date' => null
        ];

        $technician = (object)[
            'id' => 0,
            'name' => '',
            'email' => '',
            'phone' => '',
            'job_title' => '',
            'company_name' => '',
            'department_name' => ''
        ];

        $requester = (object)[
            'id' => 0,
            'name' => '',
            'email' => '',
            'phone' => '',
            'job_title' => '',
            'company_name' => '',
            'department_name' => ''
        ];

        if ($id != 0)
            $request = ClientRequest::join('companies', 'requests.company_id', 'companies.id')
                ->join('groups', 'requests.group_id', 'groups.id')
                ->join('categories', 'requests.category_id', 'categories.id')
                ->join('priorities', 'requests.priority_id', 'priorities.id')
                ->join('sla', 'requests.sla_id', 'sla.id')
                ->select(
                    'requests.*',
                    'companies.name as company_name',
                    'groups.name as group_name',
                    'categories.name as category_name',
                    'priorities.name as priority_name',
                    'sla.name as sla_name'
                )
                ->where('requests.id', $id)->first();
        if (!$request) return view('layouts.empty');

        $currentUser = Auth::user();
        $role = Role::query()->find($currentUser->role_id);
        if ($role && in_array($role->type, ['TechnicianL1', 'TechnicianL2']) && $request->technician_id != $currentUser->id) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        $clients = Client::query()->where('email', $request->client_email)->pluck('company_name', 'email')->toArray();
        $rating = Rating::where('request_id', $id)->select('id', 'rating', 'rating1', 'rating2', 'rating3', 'rating4')->first();

        if ($request->request_by != 0)
            $requester = User::join('companies', 'users.company_id', 'companies.id')
                ->join('departments', 'users.department_id', 'departments.id')
                ->where('users.id', $request->request_by)
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.job_title',
                    'companies.name as company_name',
                    'departments.name as department_name'
                )
                ->first();

        if ($request->technician_id != 0)
            $technician = User::join('companies', 'users.company_id', 'companies.id')
                ->join('departments', 'users.department_id', 'departments.id')
                ->where('users.id', $request->technician_id)
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.job_title',
                    'users.groups',
                    'companies.id as company_id',
                    'companies.name as company_name',
                    'departments.id as department_id',
                    'departments.name as department_name'
                )
                ->first();

        $departments = Department::orderBy('name', 'ASC')->select('id', 'name')->get();
        $companies = Company::orderBy('name', 'ASC')->select('id', 'name')->get();
        $groups = Group::orderBy('name', 'ASC')->get();
        $priorities = Priority::orderBy('level', 'ASC')->get();
        $slaList = SLA::orderBy('name', 'ASC')->get();
        $categories = Category::where('type', 'Default')
            ->orderBy('name', 'ASC')
            ->get();
        $solutions = Solution::whereIn('id', $request->solutions)
            ->select('id', 'name')
            ->orderBy('name', 'ASC')
            ->get();

        $changes = Change::where([['type', 'Request'], ['rel_id', $id]])
            ->orderBy('id', 'desc')->paginate(10);

        $request->root_cause = html_entity_decode($request->root_cause);
        $request->content = html_entity_decode($request->content);
        return view('layouts.requests.request')
            ->with([
                'id' => $id,
                'option' => $option,
                'request' => $request,
                'departments' => $departments,
                'companies' => $companies,
                'priorities' => $priorities,
                'sla_list' => $slaList,
                'categories' => $categories,
                'groups' => $groups,
                'requester' => $requester,
                'technician' => $technician,
                'solutions' => $solutions,
                'changes' => $changes,
                'rating' => $rating,
                'customer_company' => $clients
            ]);

    }

    public function postRequest(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'site' => ['required', 'min:2', 'max:40', 'regex:' . Data::$cleanString],
            'mode' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],

            'so' => ['sometimes', 'nullable', 'min:1', 'max:100', 'regex:' . Data::$cleanString],
            'so_status' => ['sometimes', 'nullable', 'min:3', 'max:40', 'regex:' . Data::$cleanString],

            'tac' => ['sometimes', 'nullable', 'min:1', 'max:100', 'regex:' . Data::$cleanString],
            'flag' => ['numeric', 'min:0', 'max:1'],
            'technician_id' => ['required', 'numeric', 'min:1'],
//            'new_id' => ['required', 'numeric', 'min:1'],
            'client_id' => ['required', 'numeric', 'min:0'],
            'invoice_id' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'numeric', 'min:0', 'max:50000'],
            'company_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'group_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'client_email' => ['required', 'email', 'min:8', 'max:50'],
            'request_by' => ['required', 'numeric'],
            'sla_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'priority_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'status' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'name' => ['required', 'min:3', 'max:200', 'regex:' . Data::$cleanString],
            'root_cause' => ['sometimes', 'nullable', 'min:0', 'max:16777000'],
            'post_content' => ['required', 'min:0', 'max:16777000'],
            'hidden' => ['numeric', 'min:0', 'max:1'],

            'active_date_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'active_date_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'due_by_date_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'due_by_date_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'closed_date_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'closed_date_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'response_time_estimate_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'response_time_estimate_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'response_time_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'response_time_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'resolve_time_estimate_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'resolve_time_estimate_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'resolve_time_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'resolve_time_hm' => ['sometimes', 'nullable', 'date_format:H:i'],

            'late_response_reason' => ['sometimes', 'nullable', 'max:5000'],
            'late_resolve_reason' => ['sometimes', 'nullable', 'max:5000'],

            'part_device' => ['sometimes', 'nullable', 'min:1', 'max:200'],
            'serial_number' => ['sometimes', 'nullable', 'min:1', 'max:200'],
            'tracking_number' => ['sometimes', 'nullable', 'min:1', 'max:200'],
            'rma_doa' => ['sometimes', 'nullable', 'min:1', 'max:200'],

        ], [
            'type.regex' => __('validation.clean_string'),
            'site.regex' => __('validation.clean_string'),
            'mode.regex' => __('validation.clean_string'),
            'so.regex' => __('validation.clean_string'),
            'so_status.regex' => __('validation.clean_string'),
            'tac.regex' => __('validation.clean_string'),
            'status.regex' => __('validation.clean_string'),
            'name.regex' => __('validation.clean_string')
        ]);

        $currentUser = Auth::user();
        $role = Role::query()->find($currentUser->role_id);

        $requestBy = $request->request_by ?? 0;
        if ($requestBy == 0) $requestBy = Auth::user()->id;

        $update = [
            'type' => $request->type ?? '',
            'site' => $request->site ?? '',
            'mode' => $request->mode ?? '',
            'so' => $request->so ?? '',
            'so_status' => $request->so_status ?? '',
            'solutions' => $request->solutions ?? [],
            'tac' => $request->tac ?? '',
            'flag' => $request->flag ?? 0,
            'technician_id' => $request->technician_id ?? 0,
            'technicians' => $request->technicians ?? [],
            'followers' => $request->followers ?? [],
            'attachments' => $request->attachments ?? [],
            'pending_reason' => $request->pending_reason ?? '',
            'client_id' => $request->client_id ?? 0,
            'invoice_id' => $request->invoice_id ?? 0,
            'category_id' => $request->category_id ?? 0,
            'company_id' => $request->company_id ?? 0,
            'group_id' => $request->group_id ?? 0,
            'client_email' => $request->client_email ?? 0,
            'request_by' => $requestBy,
            'sla_id' => $request->sla_id ?? 0,
            'priority_id' => $request->priority_id ?? 0,
            'status' => $request->status ?? 0,
            'name' => $request->name ?? '',
            'root_cause' => htmlentities($request->root_cause ?? ''),
            'content' => htmlentities($request->post_content ?? ''),
            'hidden' => $request->hidden ?? 0,

            'late_response_reason' => $request->late_response_reason ?? '',
            'late_resolve_reason' => $request->late_resolve_reason ?? '',

            'part_device' => $request->part_device ?? '',
            'serial_number' => $request->serial_number ?? '',
            'tracking_number' => $request->tracking_number ?? '',
            'rma_doa' => $request->rma_doa ?? '',
            'last_update' => $request->last_update ?? ''
        ];

        if ($id == 0) $update['uuid'] = Str::uuid()->toString();
        $update = Tool::generatePostDateTime('active_date', 'active_date_ymd', 'active_date_hm', $request, $update);
        $update = Tool::generatePostDateTime('due_by_date', 'due_by_date_ymd', 'due_by_date_hm', $request, $update);
        $update = Tool::generatePostDateTime('closed_date', 'closed_date_ymd', 'closed_date_hm', $request, $update);
        $update = Tool::generatePostDateTime('response_time_estimate_datetime', 'response_time_estimate_ymd', 'response_time_estimate_hm', $request, $update);
        $update = Tool::generatePostDateTime('response_time_datetime', 'response_time_ymd', 'response_time_hm', $request, $update);
        $update = Tool::generatePostDateTime('resolve_time_estimate_datetime', 'resolve_time_estimate_ymd', 'resolve_time_estimate_hm', $request, $update);
        $update = Tool::generatePostDateTime('resolve_time_datetime', 'resolve_time_ymd', 'resolve_time_hm', $request, $update);

        //Get old data for save change
        $oldData = [];
        if ($id != 0) {
            $oldData = ClientRequest::where('id', $id)->first();
            if ($role && in_array($role->type, ['TechnicianL1', 'TechnicianL2']) && $oldData->technician_id != $currentUser->id) {
                abort(403, 'Bạn không có quyền truy cập');
            }
        }

        $clientRequest = new ClientRequest();

        $result = $clientRequest->updateOrCreate([
            'id' => $id
        ], $update);

        if (!isset($result->id))
            return redirect()->back()->with(['failed' => __('admin.failed')]);
        else {

            //Save change
            (new ChangesController())->addChange('Request', '', $result->id, $oldData, $update);

            //Notify to technician
            if (in_array($result->status, ['Open', 'Answered', 'CustomerReply']))
                $this->sendNotifyToTechnician($result->id, $result->name, $result->technician_id, $result->content);

            //Active date, Send received mail to customer
            if (!isset($oldData['active_date']) && $result->status == 'Open') {

                $activeDate = Carbon::now();
                $calcTimes = (new SLAController())->calcOpenDateTimes($result->sla_id, $activeDate);

                if (isset($calcTimes['response_time_estimate_datetime']) && isset($calcTimes['resolve_time_estimate_datetime'])) {
                    $updateData = [
                        'active_date' => $activeDate,
                        'response_time_estimate_datetime' => $calcTimes['response_time_estimate_datetime'],
                        'resolve_time_estimate_datetime' => $calcTimes['resolve_time_estimate_datetime'],
                        'due_by_date' => $calcTimes['resolve_time_estimate_datetime']
                    ];
                    (new ClientRequest())->where('id', $result->id)->update($updateData);
                    $this->openTicketMail($result->id, $result->name, $result->client_email, $result->technician_id, $result->request_by, [], $result->company_id);
                }
            }

            //Create rating for first close
            if ($result->status == 'Closed' && !isset($oldData['closed_date'])) {

                $resolveTime = Carbon::now();
                $calcTimes = (new SLAController())->calcCloseDateTimes($result->sla_id, $result->active_date, $resolveTime);

                if (isset($calcTimes['resolve_time_datetime']) && isset($calcTimes['resolve_time']) && isset($calcTimes['resolve_time_late'])) {
                    $updateData = [
                        'resolve_time_datetime' => $calcTimes['resolve_time_datetime'],
                        'resolve_time' => $calcTimes['resolve_time'],
                        'resolve_time_late' => $calcTimes['resolve_time_late'],
                        'closed_date' => $resolveTime,
                        'hidden' => 1
                    ];
                    (new ClientRequest())->where('id', $result->id)->update($updateData);
                    $this->closeTicketMail($result->id, $result->uuid, $result->name, $result->client_email, [], $result->company_id);
                }
            }

            return redirect()->to('/requests/request/' . $result->id . '/edit')->with(['success' => __('admin.update_successful')]);
        }
    }

    private function sendNotifyToTechnician($requestId, $requestName, $technicianId, $contentTicket = '')
    {
        $notifyCheck = Notification::where([
            ['type', 'Request'],
            ['rel_id', $requestId],
            ['users', 'LIKE', '%"' . $technicianId . '"%']
        ])->first();
        $tech = (new User())->getUser($technicianId);
        if (!$notifyCheck && $tech) {

            (new NotificationsController())->addNotification(
                'Request',
                1,
                $requestId,
                'Yêu cầu xủ lý: ' . Tool::getTicketFullName($requestId, $requestName),
                env('APP_URL') . '/requests/request/' . $requestId,
                [(string)$technicianId],
                [$tech->email ?? ''],
                'TicketNotify',
                'assign-technical',
                $contentTicket
            );
        }
        return true;
    }

    private function openTicketMail($ticketId, $ticketName, $clientEmail, $technicianId, $requestBy, $attachments, $companyId = 0, $contentTicket = '')
    {
        $customer = (new Client())->getClientByMail($clientEmail);
        $tech = (new User())->getUser($technicianId);
        $serviceDeskUsers = (new User())->getArrUsersByRole(0, 'ServiceDesk', $companyId);
        $serviceDeskUserIds = $serviceDeskUsers[0];
        $serviceDeskUserEmails = $serviceDeskUsers[1];
        $sdName = implode(', ', $serviceDeskUsers[2]);
//        $sd = (new User())->getUser($requestBy);

        //Send notify for service desk
        $this->sendNotification(
            '',
            'Request',
            1,
            $ticketId,
            Tool::getTicketFullName($ticketId, $ticketName) . ' đã được tạo',
            env('APP_URL') . '/requests/request/' . $ticketId,
            $serviceDeskUserIds);

        // Send email to tech, customer and service desk
        (new MailController())->createMail(
            'OpenTicket',
            [
                'ticket_id' => $ticketId,
                'ticket_name' => $ticketName,
                'customer_name' => $customer->name,
                'technician_name' => $tech->name,
                'sd_name' => $sdName
            ],
            env('OUTLOOK_MAIL_ADDRESS'),
            [$tech->email],
            array_merge([$tech->email], $serviceDeskUserEmails),
            $attachments,
            0,
            $contentTicket
        );

        //Send service desk
//        if (env('CONFIG_SEND_EMAIL_UPDATE_TO_ADMIN', 1) == 1) {
//            $serviceDeskUsers = (new User())->getArrUsersByRole(0, 'ServiceDesk', $companyId);
//            $serviceDeskUserIds = $serviceDeskUsers[0];
//            $serviceDeskUserEmails = $serviceDeskUsers[1];
//
//            (new NotificationsController())->addNotification(
//                'Request',
//                1,
//                $ticketId,
//                Tool::getTicketFullName($ticketId, $ticketName) . ' đã được tạo',
//                env('APP_URL') . '/requests/request/' . $ticketId,
//                $serviceDeskUserIds,
//                $serviceDeskUserEmails,
//                'OpenTicketNotifyToAdmin',
//                ''
//            );
//        }
        return true;
    }

    private function closeTicketMail($ticketId, $ticketUUID, $ticketName, $clientEmail, $attachments, $companyId)
    {
        $customer = (new Client())->getClientByMail($clientEmail);
        (new MailController())->createMail('CloseTicket',
            [
                'customer_name' => $customer->name,
                'ticket_id' => $ticketId,
                'ticket_name' => $ticketName,
                'report_url' => env('APP_URL') . '/rating/' . $ticketUUID . '/' . encrypt($clientEmail)
            ],
            env('OUTLOOK_MAIL_ADDRESS'),
            [$clientEmail],
            [],
            $attachments
        );

        //Send service desk
        if (env('CONFIG_SEND_EMAIL_UPDATE_TO_ADMIN', 1) == 1) {
            $serviceDeskUsers = (new User())->getArrUsersByRole(0, 'ServiceDesk', $companyId);
            $serviceDeskUserIds = $serviceDeskUsers[0];
            $serviceDeskUserEmails = $serviceDeskUsers[1];

            (new NotificationsController())->addNotification(
                'Request',
                1,
                $ticketId,
                Tool::getTicketFullName($ticketId, $ticketName) . ' đã được xử lý',
                env('APP_URL') . '/requests/request/' . $ticketId,
                $serviceDeskUserIds,
                $serviceDeskUserEmails,
                'CloseTicketNotifyToAdmin',
                '',
                ''
            );
        }
        return true;
    }

    public function addSolutions(Request $request)
    {
        $id = $request->id ?? 0;
        $solutions = $request->solutions ?? [];

        $requestSolutions = [];
        if (is_array($solutions)) {
            foreach ($solutions as $solution) {
                $requestSolutions[] = (string)$solution['id'];
            }
        }

        $result = (new ClientRequest())->where('id', $id)->update([
            'solutions' => $requestSolutions
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function removeSolution(Request $request)
    {
        $id = $request->id ?? 0;
        $solutions = $request->solutions ?? [];
        $removeId = $request->remove_id ?? 0;
        if (is_array($solutions)) {
            $i = 0;
            foreach ($solutions as $solution) {
                if ($removeId == $solution['id']) {
                    unset($solutions[$i]);
                }
                $i++;
            }
        }
        $result = (new ClientRequest())->where('id', $id)->update([
            'solutions' => $solutions
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function searchRequestsJson($keyword = '')
    {
        $solutions = ClientRequest::where('name', 'LIKE', '%' . $keyword . '%')
            ->select('id', 'name')
            ->get();
        return response()->json($solutions);
    }

    public function addOutlookMails($mails)
    {
        //List mail id
        $mailIds = ClientRequest::where([['mode', 'EMail'],])->orderBy('id', 'desc')->limit(Data::$mailsLimit)->pluck('rel_id');
        $mailIds = json_decode($mailIds, true);

        //List mail reply id
        $mailReplyIds = Reply::where([['type', 'Request'], ['sent_mail', 0], ['rel_mail_id', '!=', '']])->orderBy('id', 'desc')->limit(Data::$mailsLimit)->pluck('rel_mail_id');
        $mailReplyIds = json_decode($mailReplyIds, true);

        $defaultCompany = (new Company())->getDefaultCompany();
        $defaultGroup = (new Group())->getDefaultGroup();
        $defaultCategory = (new Category())->getDefaultCategory();
        $defaultSLA = (new SLA())->getDefaultSLA();
        $defaultPriority = (new Priority())->getDefaultPriority();

        $mails = array_reverse($mails);
        foreach ($mails as $mail):

            //Check duplicate mail id
            if (!in_array($mail['id'], $mailIds) && !in_array($mail['id'], $mailReplyIds)) {

                //Check reply email
                if (preg_match('/SBD##(.*?)##/', $mail['subject'], $match)) {

                    $fromEmail = $mail['from']['emailAddress']['address'];

                    //Check user or customer
                    if (strpos($fromEmail, env('CONFIG_COMPANY_EMAIL_FORMAT')) !== false) {
                        $replierType = 'User';
                        $replier = (new User())->getUserByEmail($fromEmail);
                    } else {
                        $replierType = 'Customer';
                        $replier = (new Client())->getClientByMail($fromEmail);
                    }

                    //Save to reply for request
                    (new Reply())->create(
                        [
                            'type' => 'Request',
                            'rel_mail_id' => $mail['id'],
                            'rel_id' => $match[1],
                            'replier_type' => $replierType,
                            'replier_id' => $replier->id ?? 0,
                            'replier_name' => $replier->name ?? $fromEmail,
                            'name' => $mail['subject'],
                            'content' => '',
                            'sent_mail' => 0,
                            'attachments' => []
                        ]
                    );
                } else {

                    //Get or create client
                    $clientId = (new Client())->createClientId($mail['from']['emailAddress']['address'], $mail['from']['emailAddress']['name']);
                    $data = [
                        'uuid' => $update['uuid'] = Str::uuid()->toString(),
                        'rel_id' => $mail['id'],
                        'type' => 'Incident',
                        'site' => '',
                        'mode' => 'EMail',
                        'so' => '',
                        'tac' => '',
                        'flag' => 0,
                        'solutions' => [],
                        'technician_id' => 0,
                        'client_id' => $clientId,
                        'invoice_id' => 0,
                        'category_id' => $defaultCategory->id ?? 0,
                        'company_id' => $defaultCompany->id ?? 0,
                        'group_id' => $defaultGroup->id ?? 0,
                        'client_email' => $mail['from']['emailAddress']['address'],
                        'request_by' => 0,
                        'sla_id' => $defaultSLA->id ?? 0,
                        'priority_id' => $defaultPriority->id ?? 0,
                        'status' => 'Draft',
                        'name' => $mail['subject'],
                        'content' => '',
                        'attachments' => [],
                        'hidden' => 1,
                        'email_time' => Carbon::parse($mail['receivedDateTime'])->format('Y-m-d H:i:s')
                    ];

                    $resultId = (new ClientRequest())->create($data)->id;

                    if ($resultId) {
                        //Send reference email
                        (new MailController())->createMail(
                            'EmailReference',
                            [
                                'reference_id' => Tool::generateReferenceNumber($resultId)
                            ],
                            env('MAIL_FROM_ADDRESS'),
                            [$data['client_email']],
                            [],
                            []
                        );
                    }
                }
            }
        endforeach;
        return true;
    }

    public function updateResponseTime($requestId, $responseUserId, $sentMail)
    {
        $now = Carbon::now();
        $update = [];
        $clientRequest = ClientRequest::find($requestId);
        if (!$clientRequest) return null;

        if ($clientRequest->response_time_datetime == null && $clientRequest->technician_id == $responseUserId && $sentMail == 1) {
            $calcTimes = (new SLAController())->calcFirstResponseDateTimes($clientRequest->sla_id, $clientRequest->active_date, $now);
            if (isset($calcTimes['response_time_datetime'])) $update['response_time_datetime'] = $calcTimes['response_time_datetime'];
            if (isset($calcTimes['response_time'])) $update['response_time'] = $calcTimes['response_time'];
            if (isset($calcTimes['response_time_late'])) $update['response_time_late'] = $calcTimes['response_time_late'];
        }

        $update['status'] = 'Answered';
        $update['last_reply'] = $now;
        return (new ClientRequest())->where('id', $requestId)->update($update);
    }

    public function downloadAttachment($id = 0, $attachment_id = '')
    {
        $request = ClientRequest::select('id', 'attachments')->find($id);
        if (!$request) return null;

        foreach ($request->attachments as $attachment) {
            if ($attachment['id'] == $attachment_id) {
                header("Content-type: text/plain");
                header("Content-Disposition: attachment; filename={$attachment['name']}");
                print base64_decode($attachment['contentBytes']);
            }
        }
        return null;
    }

    private function sendNotification($key, $type, $priority, $relId, $description, $url, $users){
        if ((new Notification())->create(
            [
                'key' => $key,
                'type' => $type,
                'priority' => $priority,
                'rel_id' => $relId,
                'description' => $description,
                'url' => $url,
                'users' => $users,
                'received' => []
            ]
        )) {
            new Push('Notification', $users);
        }
    }
}
