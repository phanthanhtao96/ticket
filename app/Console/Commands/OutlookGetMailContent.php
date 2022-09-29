<?php
/***SaoBacDauTelecom***/

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OutlookController;
use App\Models\Group;
use App\Models\RocketChat;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Request as ClientRequest;

class OutlookGetMailContent extends Command
{
    protected $signature = 'cron:outlook_get_mail_content';
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
            //Id of group requester
            $requester = (new User())->getArrUsersByRole(0, 'ServiceDesk');
            $requesterIDs = $requester[0];
            $requesterEmails = $requester[1];

            ClientRequest::where([
                ['mode', 'EMail'],
                ['status', 'Draft'],
                ['rel_id', '!=', ''],
                ['hidden', 1],
                ['content', '']
            ])
                ->select(
                    'id',
                    'rel_id',
                    'name'
                )
                ->chunkById(2, function ($clientRequests) use ($outlookController, $requesterIDs, $requesterEmails) {
                    foreach ($clientRequests as $clientRequest) {
                        $mailDetail = $outlookController->getMailContent($clientRequest->rel_id);
                        if (isset($mailDetail['body']['content'])) {
                            $content = $mailDetail['body']['content'];
                            //Remove script and style tag
                            $content = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "$1$3", $content);
                            //Get attachments
                            $attachments = $outlookController->getAttachments($clientRequest->rel_id);

                            if (is_array($attachments)) {
                                foreach ($attachments as $attachment) {
                                    if (isset($attachment['contentId']) && $attachment['contentId'] != '')
                                        $content = str_replace('src="cid:' . $attachment['contentId'] . '"', 'src="data:' . $attachment['contentType'] . ';charset=utf-8;base64, ' . $attachment['contentBytes'] . '"', $content);
                                }
                                (new ClientRequest())->where('id', $clientRequest->id)->update([
                                    'content' => htmlentities($content),
                                    'hidden' => 0,
                                    'attachments' => $attachments
                                ]);

                                //Notification to requester
                                (new NotificationsController())->addNotification(
                                    'Request',
                                    1,
                                    $clientRequest->id,
                                    'Có yêu cầu mới từ email: Request #' . $clientRequest->id,
                                    env('APP_URL') . '/requests/request/' . $clientRequest->id,
                                    $requesterIDs,
                                    $requesterEmails,
                                    'NewRequestEMailNotify',
                                    'assign-requester',
                                    ''
                                );
                            }
                        }
                    }
                }, 'id');
        } catch (\Exception $e) {
            RocketChat::send('OutlookGetMailContent: ' . $e->getMessage());
        }
    }
}
