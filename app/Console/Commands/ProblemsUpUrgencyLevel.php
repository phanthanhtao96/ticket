<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProblemsUpUrgencyLevel extends Command
{
    protected $signature = 'cron:problems_up_level';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
    }
}
