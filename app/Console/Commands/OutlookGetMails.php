<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Http\Controllers\OutlookController;
use Illuminate\Console\Command;


class OutlookGetMails extends Command
{
    protected $signature = 'cron:outlook_get_mails';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $outlookController = new OutlookController();
        $outlookController->getNewMails();
    }
}