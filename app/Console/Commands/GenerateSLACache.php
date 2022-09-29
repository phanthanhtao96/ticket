<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Models\Data;
use App\Models\SLA;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateSLACache extends Command
{
    protected $signature = 'cron:generate_sla_cache';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $alsArr = [];
        $slaList = SLA::select(
            'id',
            'name'
        )
            ->get();
        foreach ($slaList as $sla) {
            $alsArr[$sla->id]['name'] = $sla->name;
        }

        Cache::put('sla_arr', $alsArr, Data::$cacheTime);
    }
}
