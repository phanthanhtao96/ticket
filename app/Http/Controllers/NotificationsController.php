<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Push;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function getNewNotificationsJson()
    {
        $myId = Auth::user()->id;
        $notifications = Notification::where([
            ['users', 'LIKE', '%"' . $myId . '"%'],
            ['received', 'NOT LIKE', '%"' . $myId . '"%']
        ])
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($notifications);
    }

    public function receivedNotification(Request $request)
    {
        $myId = Auth::user()->id;
        $notifyId = $request->notify_id ?? 0;
        $notification = Notification::where([
            ['id', $notifyId],
            ['users', 'LIKE', '%"' . $myId . '"%']
        ])
            ->select('id', 'received')
            ->first();
        if (!$notification) return response()->json(['status' => false, 'message' => __('admin.failed')]);

        $received = $notification->received;
        $received[] = (string)$myId;
        return !(new Notification())->where('id', $notifyId)->update(['received' => $received]) ?
            response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function markAsRead()
    {
        $myId = Auth::user()->id;
        $notifications = Notification::where([
            ['users', 'LIKE', '%"' . $myId . '"%'],
            ['received', 'NOT LIKE', '%"' . $myId . '"%']
        ])
            ->select('id', 'received')
            ->limit(100)
            ->get();

        foreach ($notifications as $notification) {
            $newReceived = $notification->received;
            $newReceived[] = (string)$myId;

            (new Notification())->where('users', 'LIKE', '%"' . $myId . '"%')->update([
                'received' => $newReceived
            ]);
        }

        return response()->json(['status' => true]);
    }

    public function checkHasNotifyByKey($type, $relId, $key)
    {
        $checkHasNotice = Notification::where([
            ['type', $type],
            ['key', $key],
            ['rel_id', $relId]
        ])
            ->orderBy('id', 'desc')
            ->first();

        return $checkHasNotice != null;
    }

    public function addNotification($type = '', $priority = 0, $relId = 0, $description = '', $url = '', $users = [], $emails = [], $emailType = '', $key, $contentTicket)
    {
        if ((new Notification())->create(
            [
                'key' => $key,
                'type' => $type,
                'priority' => $priority,
                'rel_id' => $relId,
                'description' => $description,
                'url' => $url,
                'users' => $users,
                'received' => []
            ]
        )) {
            new Push('Notification', $users);
        }

        $vars = [];
        //Save to mail
        if (env('CONFIG_SEND_NOTIFY_EMAIL', 0) == 1 && $emailType != '') {
            switch ($emailType):
                case 'NewRequestEMailNotify':
                    $vars = [
                        'request_id' => $relId,
                        'request_url' => $url
                    ];
                    break;
                case 'TicketNotify':
                    $vars = [
                        'ticket_id' => $relId,
                        'ticket_url' => $url
                    ];
                    break;
                case 'OpenTicketNotifyToAdmin':
                    $vars = [
                        'ticket_id' => $relId,
                        'ticket_url' => $url
                    ];
                    break;
                case 'CloseTicketNotifyToAdmin':
                    $vars = [
                        'ticket_id' => $relId,
                        'ticket_url' => $url
                    ];
                    break;
                case 'ProblemNotify':
                    $vars = [
                        'problem_id' => $relId,
                        'problem_url' => $url
                    ];
                    break;
            endswitch;
            (new MailController())->createMail($emailType, $vars, env('MAIL_FROM_ADDRESS'), array_filter($emails), [], [], 0, $contentTicket);
        }
    }
}
