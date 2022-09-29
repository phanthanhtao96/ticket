<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OutlookController;
use App\Models\Reply;
use App\Models\RocketChat;
use App\Models\Tool;
use Illuminate\Console\Command;

class OutlookGetMailReplyContent extends Command
{
    protected $signature = 'cron:outlook_get_mail_reply_content';
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
        try {
            $outlookController = new OutlookController();
            Reply::join('requests', 'replies.rel_id', 'requests.id')
                ->where([
                    ['replies.sent_mail', 0],
                    ['replies.content', ''],
                    ['rel_mail_id', '!=', '']
                ])
                ->whereIn('requests.status', ['Open', 'Answered', 'CustomerReply'])
                ->select('replies.*')->chunkById(2, function ($replies) use ($outlookController) {

                    foreach ($replies as $reply):
                        $mailDetail = $outlookController->getMailContent($reply->rel_mail_id);
                        if (isset($mailDetail['body']['content'])) {
                            $content = $mailDetail['body']['content'];
                            //Remove script and style tag
                            $content = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "$1$3", $content);
                            //Get attachments
                            $attachments = $outlookController->getAttachments($reply->rel_id);

                            if (is_array($attachments)) {
                                foreach ($attachments as $attachment) {
                                    if (isset($attachment['contentId']) && $attachment['contentId'] != '')
                                        $content = str_replace('src="cid:' . $attachment['contentId'] . '"', 'src="data:' . $attachment['contentType'] . ';charset=utf-8;base64, ' . $attachment['contentBytes'] . '"', $content);
                                }
                            }
                            (new Reply())->where('id', $reply->id)->update([
                                'content' => htmlentities($content),
                                'attachments' => $attachments
                            ]);
                        }
                    endforeach;

                }, 'replies.id', 'id');

        } catch (\Exception $e) {
            RocketChat::send('OutlookGetMailReplyContent: ' . $e->getMessage());
        }
    }
}
