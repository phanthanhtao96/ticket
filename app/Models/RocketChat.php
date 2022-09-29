<?php

namespace App\Models;
use GuzzleHttp\Client;

class RocketChat
{
    public static function send($text = '', $room = 'LOG')
   {
       $url = env('ROCKET_CHAT_HOST', '');
       $rooms = [
           'LOG' => env('ROCKET_CHAT_TOKEN_ROOM_LOG', '')
       ];

       $token = $rooms[$room] ?? $rooms['LOG'];

       $env = '[' . env('APP_ENV', '') . '] ';
       $env = strtoupper($env);

       $url = $url . '/hooks/' . $token;
       $header = [
           "content-type: application/json",
           "Authorization: Token {$token}"
       ];
       $post = [
           'username' => 'Manage Log',
           'icon_url' => 'https://chat.saobacdautelecom.vn/assets/touchicon_180.png',
           'text' => $env . $text,
       ];

       $guzzle = new Client();
       $response = $guzzle->request('POST', $url, [
           'headers' => $header,
           'json' => $post
       ]);
       return $response->getBody()->getContents();
   }
}
