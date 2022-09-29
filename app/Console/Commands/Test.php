<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Test extends Command
{
    protected $signature = 'test';
    protected $description = '';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        dd(Cache::get('priorities_arr'));
    }
}