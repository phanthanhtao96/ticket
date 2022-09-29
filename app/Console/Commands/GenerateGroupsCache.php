<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Models\Data;
use App\Models\Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateGroupsCache extends Command
{
    protected $signature = 'cron:generate_groups_cache';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $groupsArr = [];
        $groups = Group::select(
            'id',
            'name'
        )
            ->get();
        foreach ($groups as $group) {
            $groupsArr[$group->id]['name'] = $group->name;
        }

        Cache::put('groups_arr', $groupsArr, Data::$cacheTime);
    }
}
