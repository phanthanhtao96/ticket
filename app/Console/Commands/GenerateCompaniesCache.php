<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Data;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateCompaniesCache extends Command
{
    protected $signature = 'cron:generate_companies_cache';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $companiesArr = [];
        $companies = Company::select(
            'id',
            'name',
            'color'
        )
            ->get();
        foreach ($companies as $company) {
            $companiesArr[$company->id]['name'] = $company->name;
            $companiesArr[$company->id]['color'] = $company->color;
        }

        Cache::put('companies_arr', $companiesArr, Data::$cacheTime);
    }
}
