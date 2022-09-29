<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Http\Controllers\ReportsController;
use App\Models\Configuration;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PeriodicReports extends Command
{
    protected $signature = 'cron:periodic_reports';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $start = Carbon::now()->subDays(7);
        $end = Carbon::now();
        $emailVars['file_link'] = (new ReportsController())->periodicReports($start, $end, 'desc');

        if ($emailVars['file_link'] != '') {
            $emailVars['start_date'] = $start;
            $emailVars['end_date'] = $end;
            $toEmails = (new Configuration())->getConfiguration('auto_report_to_emails');
            if (is_array($toEmails) && count($toEmails) > 0) {
                (new MailController())->createMail(
                    'PeriodicReport',
                    $emailVars,
                    env('MAIL_FROM_ADDRESS'),
                    $toEmails,
                    [],
                    []
                );
            }
        }
    }
}
