<?php

namespace App\Console\Commands;

use App\Models\Data;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateUsersCache extends Command
{
    protected $signature = 'cron:generate_users_cache';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $usersArr = [];
        $userEmailsArr = [];
        $users = User::join('companies', 'users.company_id', 'companies.id')
            ->join('roles', 'users.role_id', 'roles.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'companies.id as company_id',
                'companies.name as company_name',
                'companies.color',
                'roles.name as role_name'
            )
            ->get();

        foreach ($users as $user) {
            $usersArr[$user->id]['name'] = $user->name;
            $usersArr[$user->id]['color'] = $user->color;

            $userEmailsArr[$user->email]['id'] = $user->id;
            $userEmailsArr[$user->email]['name'] = $user->name;
            $userEmailsArr[$user->email]['role_name'] = $user->role_name;
            $userEmailsArr[$user->email]['color'] = $user->color;
        }

        Cache::put('users_arr', $usersArr, Data::$cacheTime);
        Cache::put('user_emails_arr', $userEmailsArr, Data::$cacheTime);
    }
}
