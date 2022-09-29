<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\SendMailable;
use App\Models\Data;
use App\Models\Email;
use App\Models\EmailTemplate;
use Carbon\Carbon;

class MailController extends Controller
{
    public function createMail($type, $vars, $from, $toEmails, $ccEmails, $attachments, $relId = 0, $contentTicket = '')
    {
        //Get mail template
        $emailTemplate = (new EmailTemplate())->getEMailTemplate($type);
        $signature = (new EmailTemplate())->getEMailTemplate('Signature');
        if (!$emailTemplate || !$signature) return false;

        $subject = $this->setVars($vars, $emailTemplate->subject);
        $content = $this->setVars($vars, $emailTemplate->content);

        if (!empty($contentTicket)) $content .= htmlspecialchars_decode($contentTicket);

        if (!in_array($type, Data::$noSignatureMails))
            $content .= $signature->content;

        $sent = 1;

        if (in_array($type, Data::$outlookMailTypes)) {
            //Send by outlook mail
            $sent = 0;
        } else {
            //Send by queue mail
            $data = [
                'from' => $from,
                'to'   => array_filter($toEmails),
                'cc'   => array_filter($ccEmails),
                'subject' => $subject,
                'content' => $content
            ];
            (new MailController())->addMail($data);
//            foreach ($toEmails as $toEmail) {
//                if (empty($toEmail)) continue;
//                $data = [
//                    'from' => $from,
//                    'to' => $toEmail,
//                    'subject' => $subject,
//                    'content' => $content
//                ];
//                (new MailController())->addMail($data);
//            }
        }

        (new Email())->create(
            [
                'type' => $type,
                'rel_id' => $relId,
                'name' => $subject,
                'content' => htmlentities($content),
                'from' => $from,
                'to' => $toEmails,
                'cc' => $ccEmails,
                'sent' => $sent,
                'attachments' => $attachments
            ]
        );

        return true;
    }

    public function createMailForInternal($type, $vars, $from, $toEmails, $ccEmails, $attachments, $relId = 0)
    {
        //Get mail template
        $emailTemplate = (new EmailTemplate())->getEMailTemplate($type);
        $signature = (new EmailTemplate())->getEMailTemplate('Signature');
        if (!$emailTemplate || !$signature) return false;

        $subject = $this->setVars($vars, $emailTemplate->subject);
        $content = $this->setVars($vars, $emailTemplate->content);

        if (!in_array($type, Data::$noSignatureMails))
            $content .= $signature->content;

        //Send by queue mail
        $data = [
            'from' => $from,
            'to'   => array_filter($toEmails),
            'cc'   => array_filter($ccEmails),
            'subject' => $subject,
            'content' => $content
        ];
        (new MailController())->addMail($data);

        (new Email())->create(
            [
                'type' => $type,
                'rel_id' => $relId,
                'name' => $subject,
                'content' => htmlentities($content),
                'from' => $from,
                'to' => $toEmails,
                'cc' => $ccEmails,
                'sent' => 1,
                'attachments' => $attachments
            ]
        );

        return true;
    }

    public function setVars($vars, $string)
    {
        foreach ($vars as $key => $value) {
            $string = str_replace('[[' . $key . ']]', $value, $string);
        }
        return $string;
    }

    public function addMail($data)
    {
        $sendMailable = new SendMailable($data);
        $sendEmailJob = new SendEmail($sendMailable);
        return dispatch($sendEmailJob);
    }

    public function getEmailSentList()
    {
        $emails = Email::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.emails.email-sent-list')->with(['emails' => $emails]);
    }

    public function getEmail($id = 0)
    {
        $email = Email::find($id);
        return !$email ? view('layouts.empty') :
            view('layouts.emails.email')->with(['id' => $id, 'email' => $email]);
    }
}
