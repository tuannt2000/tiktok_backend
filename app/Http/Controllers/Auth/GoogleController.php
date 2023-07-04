<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function loginCallback(Request $request)
    {
        $token = $request->access_token;
        $userCurrent = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$token);
        $userData = json_decode($userCurrent);
        $social_id = $userData->id;
        $social_provider = 'google';
        $user = User::where([
                'social_id' => $social_id,
                'social_provider' => $social_provider
            ])->first();
        try {
            if (!$user) {  
                $nickname = '';
                while (true) {
                    $nickname = Str::random(8);
                    $isset_nickname =  User::where('nickname', $nickname)->first();

                    if (!$isset_nickname) {
                        break;
                    }
                }       
                $user = User::create([
                    'email' => $userData->email,
                    'social_provider' => 'google',
                    'social_id' => $userData->id,
                    'first_name' => $userData->given_name,
                    'last_name' => $userData->family_name,
                    'nickname' => 'user' . $nickname,
                    'birthday' => date("Y-m-d H:i:s"),
                    'avatar' => $userData->picture
                ]);
            }  
            
            Auth::login($user);
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'data' => [
                    'code' => 200,
                    'message' => trans('messages.loginWithGoogleSuccess'),
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ]
            ]);
        } catch (\Throwable $err) {
            Log::error($err);
            return response()->json([
                'data' => [
                    'code' => 401,
                    'message' => trans('messages.loginWithGoogleFailt'),
                ],
            ]);
        }
    }
}
