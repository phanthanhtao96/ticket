<?php

namespace App\Models;

use Carbon\Carbon;

class Tool
{
    public static function errorString($errors)
    {
        $string = '';
        foreach ($errors as $error) {
            $string .= $error . ', ';
        }
        return substr($string, 0, -2);
    }

    public static function curl($url, $method, $header, $post, $getHeader = false)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => $getHeader,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "$method",
                CURLOPT_POSTFIELDS => $post,
                CURLOPT_HTTPHEADER => $header
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            return !$err ? $response : json_encode(['status' => false]);
        } catch (\Exception $e) {
            return json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public static function randomPassword($len = 10)
    {
        $sets = [];
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '123456789';
        $sets[] = '!@$^';

        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }
        while (strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        return str_shuffle($password);
    }

    public static function getTicketNum($id)
    {
        $format = env('CONFIG_TICKET_NUM_FORMAT');
        return str_replace('{{ID}}', $id, $format);
    }

    public static function getTicketFullName($id, $name)
    {
        $format = env('CONFIG_TICKET_NUM_FORMAT');
        $num = str_replace('{{ID}}', $id, $format);
        return $num . ' ' . $name;
    }

    public static function generatePostDateTime($dateTimeColumn, $postYmd, $postHm, $request, $update)
    {
        $ymd = $request[$postYmd] ?? null;
        $hm = $request[$postHm] ?? null;
        if ($ymd && $hm)
            $update[$dateTimeColumn] = Carbon::parse($ymd . ' ' . $hm)->format('Y-m-d H:i:00');
        return $update;
    }

    public static function generateTimeProgressBar($startTime, $endTime, $class = 'shadow-2', $height = 12)
    {
        $percent = 0;
        $variant = 'success';

        $resolveStart = Carbon::parse($startTime);
        $resolveEnd = Carbon::parse($endTime);
        $resolveAfterMinutes = $resolveEnd->diffInMinutes($resolveStart);

        $start = Carbon::parse($startTime);
        $end = Carbon::parse(Carbon::now());
        $currentMinutes = $end->diffInMinutes($start);

        if ($resolveAfterMinutes > $currentMinutes) {
            $percent = ((int)$currentMinutes / (int)$resolveAfterMinutes) * 100;
            $percent = 100 - $percent;
        }

        if ($percent < 50) $variant = 'warning';
        if ($percent < 25) $variant = 'danger';

        return '<b-progress :max="100" :value="' . (int)$percent . '" ' .
            'variant="' . $variant . '" ' .
            'class="' . $class . '" ' .
            'height="' . $height . 'px" ' .
            'v-b-tooltip.hover title="' . __('admin.due_date') . ' ' . Carbon::parse($endTime)->format('H:i d/m/Y') . '" ' .
            'striped animated>' .
            '</b-progress>';
    }

    public static function generateReferenceNumber($id)
    {
        return (int)$id + 5000005;
    }

    public static function calcMinutesToDays($minutes)
    {
        if ($minutes <= 0) return '-';

        $days = '';
        $hours = str_pad(floor($minutes / 60), 2, "0", STR_PAD_LEFT);
        $minutes = str_pad($minutes % 60, 2, "0", STR_PAD_LEFT);

        if ((int)$hours > 24) {
            $days = str_pad(floor($hours / 24), 2, "0", STR_PAD_LEFT);
            $hours = str_pad($hours % 24, 2, "0", STR_PAD_LEFT);
        }
        if (isset($days) && $days != '') {
            $days = $days . "d ";
        }

        return $days . $hours . "h " . $minutes . "m";
    }

    public static function lastDayOfCurrentMonth()
    {
        $maxDays = date('t');
        return $maxDays;
    }

    public static function generateHeaderOfDutyList($day)
    {
        $date = Carbon::now()->format('Y-m-' . $day);
        $weekday = date('w', strtotime($date));
        $weekdayLabel = isset(Data::$weekdays[$weekday]) ? Data::$weekdays[$weekday] : '';
        $classColor = $weekday == 0 || $weekday == 6 ? 'text-danger' : '';
        $html = '<div class="duty-list-box-header ' . $classColor . '"><b>' . $weekdayLabel . '</b>: ' . Carbon::parse($date)->format('d/m/Y') . '</div>';
        return $html;
    }

    public static function convertColumnLabel($column)
    {
        if (strpos($column, '_id') !== false) {
            $column = str_replace('_id', '', $column);
        }
        $column = str_replace(['_', 'datetime'], ' ', $column);
        return strtoupper($column);
    }

    // Add attachment to message email
    public static function addAttachmentForMail($attachments, $message) : string{
        $attachmentHTML = '';
        if (count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $attachmentHTML .= '<p><a href="' . $attachment['url'] . '" target="_blank" style="border: 1px solid #ccc; padding: 10px 20px; margin-right: 5px">' . $attachment['name'] . '</a></p>';
            }
        }
        $message .= $attachmentHTML;

        return $message;
    }
}
