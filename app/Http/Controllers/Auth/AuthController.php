<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'social_provider' => 'normal'
            ])) {  
                return response()->json([
                    'data' => [
                        'code' => 400,
                        'message' => "Email hoặc mật khẩu không chính xác",
                    ],
                ], 400);
            }
            $user = User::where([
                'email' => $request->email,
                'social_provider' => 'normal'
            ])->first();
            
            Auth::login($user);
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'data' => [
                    'code' => 200,
                    'message' => "Đăng nhập thành công",
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
                    'code' => 400,
                    'message' => trans('Đăng nhập thất bại'),
                ],
            ], 400);
        }
    }

    public function register(Request $request)
    {
        $social_provider = 'normal';
        $user = User::where([
                'email' => $request->email
            ])->first();
        try {
            if ($user) {  
                return response()->json([
                    'data' => [
                        'code' => 400,
                        'message' => "Email đã tồn tại",
                    ],
                ], 400);
            }
            $nickname = '';
            while (true) {
                $nickname = Str::random(8);
                $isset_nickname =  User::where('nickname', $nickname)->first();

                if (!$isset_nickname) {
                    break;
                }
            }       

            $user = User::create([
                'email' => $request->email,
                'social_provider' => $social_provider,
                'social_id' => 0,
                'first_name' => explode("@", $request->email)[0],
                'last_name' => '',
                'nickname' => 'user' . $nickname,
                'birthday' => date("Y-m-d H:i:s")
            ]);

            $user->password = Hash::make($request->password);
            $user->save();
            
            Auth::login($user);
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'data' => [
                    'code' => 200,
                    'message' => "Đăng ký thành công",
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
                    'code' => 400,
                    'message' => trans('Đăng ký thất bại'),
                ],
            ], 400);
        }
    }
}
