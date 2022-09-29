<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\RocketChat;
use GuzzleHttp\Client;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class OutlookController extends Controller
{
    protected $token;

    /**
     * OutlookController constructor.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct()
    {
        $this->token = $this->getToken();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getToken()
    {
        $guzzle = new Client();
        $url = 'https://login.microsoft.com/' . env('AZURE_TENANT_ID', '') . '/oauth2/v2.0/token';
        $token = json_decode($guzzle->post($url, [
            'form_params' => [
                'client_id' => env('AZURE_CLIENT_ID', ''),
                'client_secret' => env('AZURE_CLIENT_SECRET', ''),
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'password',
                'userName' => env('OUTLOOK_MAIL_ADDRESS', ''),
                'password' => env('OUTLOOK_MAIL_PASSWORD', '')

            ],
        ])->getBody()->getContents());
        return $token->access_token;
    }

    public function getNewMails()
    {
        try {
            $graph = new Graph();
            $graph->setAccessToken($this->token);

            $messageQueryParams = array(
                "\$select" => "subject,receivedDateTime,from,body",
                "\$orderby" => "receivedDateTime DESC",
                "\$top" => Data::$mailsLimit,
                "\$format" => "json"
            );

            $url = '/me/mailfolders/inbox/messages?' . http_build_query($messageQueryParams);
            $messages = $graph->createRequest('GET', $url)
                ->setReturnType(Model\Message::class)
                ->execute();

            $messages = json_encode($messages);
            $messages = json_decode($messages, true);

            return (new RequestsController())->addOutlookMails($messages);
        } catch (\Exception $e) {
            RocketChat::send($e->getMessage());
            return false;
        }
    }

    public function getMailContent($id)
    {
        try {
            $graph = new Graph();
            $graph->setAccessToken($this->token);
            $url = '/me/messages/' . $id;
            $message = $graph->createRequest('GET', $url)
                ->setReturnType(Model\Message::class)
                ->execute();

            $message = json_encode($message);
            return json_decode($message, true);

        } catch (\Exception $e) {
            RocketChat::send($e->getMessage());
            return false;
        }
    }

    public function getAttachments($id)
    {
        try {
            $graph = new Graph();
            $graph->setAccessToken($this->token);
            $url = '/me/messages/' . $id . '/attachments';
            $attachments = $graph->createRequest('GET', $url)
                ->setReturnType(Model\Message::class)
                ->execute();
            $attachments = json_encode($attachments);
            return json_decode($attachments, true);

        } catch (\Exception $e) {
            return false;
        }
    }

    public function sendMail($to, $ccMails = [], $subject, $content, $mergeRecipients = false)
    {
        try {
            $graph = new Graph();
            $graph->setAccessToken($this->token);
            $mailBody = [
                'message' => [
                    'subject' => $subject,
                    'body' => [
                        'contentType' => 'html',
                        'content' => $content
                    ],
                    'toRecipients' => [
                        [
                            'emailAddress' => [
                                'address' => $to
                            ]
                        ]
                    ]
                ]
            ];


            //If has cc mails
            if (count($ccMails) > 0) {
                $recipientType = $mergeRecipients == false ? 'ccRecipients' : 'toRecipients';
                foreach ($ccMails as $ccMail) {
                    if ($ccMail == '') continue;
                    $mailBody['message'][$recipientType][] = [
                        'emailAddress' => [
                            'address' => $ccMail
                        ]
                    ];
                }
            }

            $graph->createRequest("POST", "/me/sendMail")
                ->attachBody($mailBody)
                ->execute();
            return true;

        } catch (\Exception $e) {
            RocketChat::send($e->getMessage());
            return false;
        }
    }

    public function sendReplyAll($mailId, $content)
    {
        try {
            $graph = new Graph();
            $graph->setAccessToken($this->token);
            $mailBody = [
                'comment' => $content
            ];

            $graph->createRequest("POST", "/me/messages/" . $mailId . '/replyAll')
                ->attachBody($mailBody)
                ->execute();
            return true;

        } catch (\Exception $e) {
            RocketChat::send($e->getMessage());
            return false;
        }
    }
}
