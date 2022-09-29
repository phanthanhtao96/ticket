<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearAll extends Command
{
    protected $signature = 'cache:clear';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Cache::flush();
        $this->info('ok');
    }
}
