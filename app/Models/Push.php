<?php

namespace App\Models;

class Push
{
    public function __construct($key, $value)
    {
        $url = env('MIX_PORTAL_EXTEND_SOCKET_HOST') . '/api/ticket-push';
        $header = [
            'content-type: application/json'
        ];
        $post = [
            'key' => $key,
            'value' => $value
        ];
        return Tool::curl($url, 'POST', $header, json_encode($post));
    }
}
