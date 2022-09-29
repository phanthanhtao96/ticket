<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Models\Data;
use App\Models\Priority;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GeneratePrioritiesCache extends Command
{
    protected $signature = 'cron:generate_priorities_cache';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $prioritiesArr = [];
        $priorities = Priority::select(
            'id',
            'name'
        )
            ->get();
        foreach ($priorities as $priority) {
            $prioritiesArr[$priority->id]['name'] = $priority->name;
        }

        Cache::put('priorities_arr', $prioritiesArr, Data::$cacheTime);
    }
}
