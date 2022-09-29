<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Data;
use App\Models\Reply;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RepliesController extends Controller
{
    public function getRepliesJson($type = 'Request', $id = 0)
    {
        $replies = Reply::where([
            ['replies.type', $type],
            ['replies.rel_id', $id]
        ])
            ->orderBy('replies.id', 'asc')
            ->get();

        foreach ($replies as $reply) {
            $reply->content = html_entity_decode($reply->content);
        }

        return response()->json($replies);
    }

    public function postReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'message' => ['required', 'min:1', 'max:16777000'],
            'sent_mail' => ['sometimes', 'nullable']
        ], [
            'type.regex' => __('validation.clean_string')
        ]);

        if ($validator->fails()) {
            $errors = Tool::errorString($validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errors,
            ]);
        }

        $sentMail = $request->sent_mail ?? '';
        $sentMail = $sentMail == 1 ? 1 : 0;
        $sendMailInternal = $request->send_mail_internal ?? 0;
        $message = $request->message ?? '';
        $requestName = $request->name ?? '';
        $attachments = $request->attachments ?? [];
        $requestId = $request->id ?? 0;
        $technicalId = $request->technical_id ?? 0;

        $post = [
            'type' => $request->type ?? '',
            'rel_id' => $requestId,
            'replier_type' => 'User',
            'replier_id' => Auth::user()->id,
            'replier_name' => Auth::user()->name,
            'name' => env('CONFIG_EMAIL_REPLY_PREFIX', 'Re:') . Tool::getTicketFullName($requestId, $requestName),
            'content' => htmlentities($message),
            'sent_mail' => $sentMail,
            'send_mail_internal' => $sendMailInternal,
            'attachments' => $attachments
        ];

        $result = (new Reply())->create($post);

        if (!$result) return response()->json(['status' => false, 'message' => __('admin.failed')]);
        else {

            //Update response time
            if ($post['type'] == 'Request')
                (new RequestsController())->updateResponseTime($requestId, Auth::user()->id, $sentMail);
            if ($post['type'] == 'Problem')
                (new ProblemsController())->updateResponseTime($requestId, Auth::user()->id, $sentMail);

            if ($post['sent_mail'] == 1) {
                $customerEmail = $request->customer_email ?? '';
            }

            if ($post['send_mail_internal'] == 1) {
                $technical = User::query()->find($technicalId);
                $internalMail = empty($technical) ? '' : $technical->email;
            }
            //Send mail
            if ($post['type'] == 'Request' && ($post['sent_mail'] == 1 || $post['send_mail_internal'] == 1)) {
                $clientModel = new Client();
                $userModel   = new User();

                if (!empty($customerEmail) && !empty($requestName)) {
                    $clientModel->sendMailToCustomer($requestName, $message, $attachments, $requestId, $customerEmail);
                }

                if (!empty($internalMail) && !empty($requestName)) {
                    $userModel->sendMailToInternal($requestName, $message, $attachments, $requestId, $internalMail);
                }
            }
            return response()->json(['status' => true, 'message' => __('admin.update_successful')]);
        }
    }
}
