<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Http\Controllers\OutlookController;
use App\Models\Data;
use App\Models\Email;
use App\Models\Request;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    protected $signature = 'cron:send_mails';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Email::where('sent', 0)
            ->whereIn('type', Data::$outlookMailTypes)
            ->chunkById(2, function ($emails) {
                foreach ($emails as $email) {
                    $sent = 0;
                    foreach ($email->to as $to) {
                        if ($to == '') continue;
                        if ($email->type == 'ReplyTicketEmail' && $email->rel_id != 0) {
                            $request = Request::where('id', $email->rel_id)->select('rel_id')->first();
                            if ($request) {
                                if ((new OutlookController())->sendReplyAll($request->rel_id, html_entity_decode($email->content))) $sent = 1;
                            }
                        } elseif ($email->type == 'OpenTicket') {
                            if ((new OutlookController())->sendMail($to, $email->cc, $email->name, html_entity_decode($email->content), true)) $sent = 1;
                        } else {
                            if ((new OutlookController())->sendMail($to, $email->cc, $email->name, html_entity_decode($email->content))) $sent = 1;
                        }
                    }
                    if ($sent == 1) (new Email())->where('id', $email->id)->update(['sent' => 1]);
                }
            }, 'id');
    }
}