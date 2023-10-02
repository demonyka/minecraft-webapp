<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use App\Models\User;

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
    public function registration(Request $request) {
        if($this->checkUser($request->query_id, $request->user, $request->auth_date, $request->hash) != true) {
            return inertia('AuthError');
        }
        $user_json = json_decode($request->user);
        if (!User::where('user_id', $user_json->id)->exists()) {
            if ($request->has('nickname') && $request->has('password') && $request->has('email')) {
                $userData = [
                    'user_id' => $user_json->id,
                    'nickname' => $request->nickname,
                    'email' => $request->email,
                    'password' => $request->password,
                    'referal' => $request->referal,
                ];
                User::insert($userData);
                $initData = [
                    'query_id' => $request->query_id,
                    'user' => $request->user,
                    'auth_date' => $request->auth_date,
                    'hash' => $request->hash,
                ];
                return redirect()->route('cabinet', $initData);
            } else {
                return inertia('Registration');
            }
        } else {
            return inertia('AuthError');
        }
    }
    public function cabinet(Request $request) {
        if($this->checkUser($request->query_id, $request->user, $request->auth_date, $request->hash) != true) {
            return inertia('AuthError');
        } else {
            $initData = [
                'query_id' => $request->query_id,
                'user' => $request->user,
                'auth_date' => $request->auth_date,
                'hash' => $request->hash,
            ];
            $user_json = json_decode($request->user);
            if (!User::where('user_id', $user_json->id)->exists()) {
                return redirect()->route('registration', $initData);
            }
        }
        $userData = User::where('user_id', $user_json->id)->first();
        return inertia('Cabinet', ['userData' => $userData]);
    }

}
