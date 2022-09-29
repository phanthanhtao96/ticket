<?php

namespace App\Console;

use App\Models\Configuration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        'App\Console\Commands\OutlookGetMails',
        'App\Console\Commands\OutlookGetMailContent',
        'App\Console\Commands\OutlookGetMailReplyContent',
        'App\Console\Commands\SendEmails',
        'App\Console\Commands\RequestsUpUrgencyLevel',
        'App\Console\Commands\ProblemsUpUrgencyLevel',
        'App\Console\Commands\PeriodicReports',

        'App\Console\Commands\GenerateCompaniesCache',
        'App\Console\Commands\GenerateGroupsCache',
        'App\Console\Commands\GenerateUsersCache',
        'App\Console\Commands\GenerateSLACache',
        'App\Console\Commands\GeneratePrioritiesCache',
        'App\Console\Commands\GenerateCategoriesCache'
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron:outlook_get_mails')->everyMinute()->withoutOverlapping();
        $schedule->command('cron:outlook_get_mail_content')->everyMinute()->withoutOverlapping();
        $schedule->command('cron:outlook_get_mail_reply_content')->everyMinute()->withoutOverlapping();
        $schedule->command('cron:send_mails')->everyMinute()->withoutOverlapping();


        //Auto report
        $weekdayAutoReport = (new Configuration())->getConfiguration('weekday_auto_report');
        $timeAutoReport = (new Configuration())->getConfiguration('time_auto_report');
        $schedule->command('cron:cron:periodic_reports')->weeklyOn($weekdayAutoReport, $timeAutoReport)->withoutOverlapping();
        //

        $schedule->command('cron:requests_up_level')->everyMinute()->withoutOverlapping();

        $schedule->command('cron:generate_companies_cache')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('cron:generate_groups_cache')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('cron:generate_users_cache')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('cron:generate_sla_cache')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('cron:generate_priorities_cache')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('cron:generate_categories_cache')->everyTenMinutes()->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}