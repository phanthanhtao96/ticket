<?php

namespace App\Models;

use App\Http\Controllers\MailController;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin',
        'role_id',
        'company_id',
        'region',
        'department_id',
        'groups',
        'name',
        'job_title',
        'email',
        'password',
        'image',
        'phone',
        'options',
        'email_verified_at',
        'notes',
        'disable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGroupsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setGroupsAttribute($value)
    {
        $this->attributes['groups'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getDefaultUser()
    {
        if (!Cache::has('default_user')) {
            $user = $this->where('admin', 1)->orderBy('id', 'asc')->first();
            Cache::add('default_user', $user, Data::$cacheTime);
        } else {
            $user = Cache::get('default_user');
        }
        return $user;
    }

    public function getUser($id)
    {
        if (!Cache::has('user_' . $id)) {
            $user = $this->find($id);
            Cache::add('user_' . $id, $user, Data::$cacheTime);
        } else {
            $user = Cache::get('user_' . $id);
        }
        return $user;
    }

    public function getUserByEmail($email, $company = 0, $group = 0)
    {
        $conditions = [];
        $email = trim($email);
        $conditions[] = ['email', $email];
        if ($company != 0)
            $conditions[] = ['company_id', $company];
        if ($group != 0)
            $conditions[] = ['groups', 'LIKE', '%"' . $group . '"%'];

        if (!Cache::has('user_' . $email . '_' . $company . $group)) {
            $user = $this->where($conditions)->first();
            Cache::add('user_' . $email . '_' . $company . $group, $user, Data::$cacheTime);
        } else {
            $user = Cache::get('user_' . $email . '_' . $company . $group);
        }
        return $user;
    }

    public function getArrUsersByCompany($companyId)
    {
        $users = User::where('company_id', $companyId)->slect('id', 'email')->get();
        $stringIds = [];
        $emails = [];
        foreach ($users as $user) {
            $stringIds[] = (string)$user->id;
            $emails[] = $user->email;
        }
        return [$stringIds, $emails];
    }

    public function getArrUsersByGroup($groupId)
    {
        $users = User::where('groups', 'LIKE', '%"' . $groupId . '"%')->select('id', 'email')->get();
        $stringIds = [];
        $emails = [];
        foreach ($users as $user) {
            $stringIds[] = (string)$user->id;
            $emails[] = $user->email;
        }
        return [$stringIds, $emails];
    }

    public function getArrUsersByRole($roleId = 0, $type = '', $company = 0, $group = 0, $region = '', $onDuty = false)
    {
        $conditions = [];
        if ($roleId != 0)
            $conditions[] = ['roles.id', $roleId];
        if ($type != '')
            $conditions[] = ['roles.type', $type];
        if ($company != 0)
            $conditions[] = ['users.company_id', $company];
        if ($group != 0)
            $conditions[] = ['users.groups', 'LIKE', '%"' . $group . '"%'];
        if ($region != '')
            $conditions[] = ['region', $region];

        $users = User::join('roles', 'users.role_id', 'roles.id')
            ->where($conditions)->select('users.id', 'users.email', 'users.name')->get();

        $stringIds = [];
        $emails = [];
        $names = [];

        $onDutyList = [];
        if ($onDuty) {
            $onDutyList = $this->getOnDutyTechnician();
        }

        foreach ($users as $user) {

            if ($onDuty) {
                if (in_array($user->email, $onDutyList)) {
                    $stringIds[] = (string)$user->id;
                    $emails[] = $user->email;
                    $names[] = $user->name;
                }
            } else {
                $stringIds[] = (string)$user->id;
                $emails[] = $user->email;
                $names[] = $user->name;
            }
        }
        return [$stringIds, $emails, $names];
    }

    public function getOnDutyTechnician($type = '', $company = 0, $group = 0, $region = '')
    {
        $now = Carbon::now()->format('Y-m-d H:i:00');
        //Check office hours
        $inOfficeHour = false;
        $officeHours = (new Configuration())->getConfiguration('office_hours');
        if (is_array($officeHours)) {
            foreach ($officeHours as $officeHour) {
                $times = explode('-', $officeHour);
                if (isset($times[0]) && isset($times[1])) {
                    if (Carbon::now()->format('Y-m-d ' . $times[0] . ':00') < $now && $now < Carbon::now()->format('Y-m-d ' . $times[1] . ':00')) $inOfficeHour = true;
                }
            }
        }
        //Get technicians emails
        $dutyList = DutyList::find(env('DUTY_LIST_ID', 1));
        if ($inOfficeHour) {
            $dutyListEmail = $dutyList->data[Carbon::now()->format('d')]['office_hours'] ?? [];
        } else {
            $dutyListEmail = $dutyList->data[Carbon::now()->format('d')]['outside_office_hours'] ?? [];
        }

        return $dutyListEmail;
    }

    public function getAllUsersInvolve($technicianId, $technicians, $requestBy, $followers)
    {
        $userIds = [];
        $userEmails = [];
        $technician = (new User())->getUser($technicianId);
        if ($technician) {
            $userIds[] = (string)$technician->id;
            $userEmails[] = $technician->email;
        }
        $requester = (new User())->getUser($requestBy);
        if ($requester) {
            $userIds[] = (string)$requester->id;
            $userEmails[] = $requester->email;
        }
        if (count($followers) > 0) {
            foreach ($followers as $email) {
                $follower = (new User())->getUserByEmail($email);
                if ($follower) {
                    $userIds[] = (string)$follower->id;
                    $userEmails[] = $follower->email;
                }
            }
        }
        if (count($technicians) > 0) {
            foreach ($technicians as $email) {
                $technician = (new User())->getUserByEmail($email);
                if ($technician) {
                    $userIds[] = (string)$technician->id;
                    $userEmails[] = $technician->email;
                }
            }
        }
        return [array_values(array_unique($userIds)), array_values(array_unique($userEmails))];
    }

    public function getAllUserByEmailTags($emailTags, $company = 0, $group = 0)
    {
        $userIds = [];
        $userEmails = [];
        if (count($emailTags) > 0) {
            foreach ($emailTags as $email) {
                $follower = (new User())->getUserByEmail($email, $company, $group);
                if ($follower) {
                    $userIds[] = (string)$follower->id;
                    $userEmails[] = $follower->email;
                }
            }
        }
        return [$userIds, $userEmails];
    }

    public function sendMailToInternal($requestName, $message, $attachments, $requestId, $internalEmail){
        $content = Tool::addAttachmentForMail($attachments, $message);

        $internalInfo = self::getUserByEmail($internalEmail);
        (new MailController())->createMailForInternal(
            'ReplyTicketEmail',
            [
                'ticket_id' => $requestId,
                'ticket_name' => $requestName,
                'customer_name' => $internalInfo->name,
                'reply_content' => $content
            ],
            env('OUTLOOK_MAIL_ADDRESS'),
            [$internalEmail],
            [],
            $attachments,
            $requestId
        );

        return 0;
    }
}
