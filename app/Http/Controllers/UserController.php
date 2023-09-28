<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function sendTelegramMessage($chatId, $message, $link = null)
    {
        $botToken = env('BOT_API');
        $url = "https://api.telegram.org/bot$botToken/sendMessage";

        if($link == null) {
            $response = Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $response = Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            [
                                'text' => 'Перейти',
                                'web_app' => [
                                    'url' => $link
                                    ]
                            ],
                        ],
                    ],
                ]),
                'openUrl' => $link, // Add this line to open the web app
            ]);
        }
        return $response->json();
    }
    public function checkUser($query_id, $user, $auth_date, $hash)
    {
        $initData = [
            'query_id' => $query_id,
            'user' => $user,
            'auth_date' => $auth_date
        ];
        ksort($initData);

        $data_check_string = '';
        foreach ($initData as $key => $value) {
            $data_check_string .= $key . '=' . $value . "\n";
        }
        $data_check_string = rtrim($data_check_string);
        $secret_key = hash_hmac('sha256', env('BOT_API'), "WebAppData", true);
        if(hash_hmac('sha256', $data_check_string, $secret_key) == $hash) {
            return true;
        } else {
            return false;
        }

    }
    public function cabinet(Request $request) {
        if($this->checkUser($request->query_id, $request->user, $request->auth_date, $request->hash) != true) {
            return inertia('AuthError');
        }
        return inertia('Cabinet');
    }

}
