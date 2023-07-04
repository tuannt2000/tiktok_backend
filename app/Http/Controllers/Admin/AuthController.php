<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class AuthController extends Controller
{
    public function login() {
        return view('content/auth/login');
    }

    public function postLogin(LoginRequest $request) {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            if (Auth::user()->role == 'ADM') {
                return redirect()->route('dashboard')->with('flashSuccess', 'Đăng nhập thành công');
            }

            Auth::logout();
        }

        return redirect()->back()
            ->withInput()
            ->with('flashError', 'Email hoặc mật khẩu không chính xác');
    }

    public function forgotPassword() {
        return view('content/auth/forgot_password');
    }

    public function postForgotPassword(ForgotPasswordRequest $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return redirect()->back()
            ->withInput()
            ->with('flashError', 'Email không chính xác');
        }

        $token = Str::random(64);
  
        DB::table('password_resets')->insert([
            'email' => $validated['email'], 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('elements.email.forget_password', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('flashSuccess', 'Chúng tôi đã gửi link reset password đến mail, hãy kiểm tra');
    }

    public function resetPassword(Request $request) {
        $token = $request->token ?? null;
        return view('content/auth/reset_password', compact('token'));
    }

    public function postResetPassword(ResetPasswordRequest $request) {
        $validated = $request->validated();

        $password_reset = DB::table('password_resets')->where([
            'token' => $validated['token'],
        ])->first();

        if (!$password_reset) {
            return redirect()->back()
                ->withInput()
                ->with('flashError', 'Có lỗi xảy ra, vui lòng thử lại');
        }

        $email = $password_reset->email;

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()
                ->withInput()
                >with('flashError', 'Có lỗi xảy ra, vui lòng thử lại');
        }

        $user->password = Hash::make($validated['password']);

        if ($user->save()) {
            return redirect()->route('login')->with('flashSuccess', 'Đổi mật khẩu thành công');
        }

        return redirect()->back()
            ->withInput()
            >with('flashError', 'Có lỗi xảy ra, vui lòng thử lại');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login')->with('flashSuccess', 'Đăng xuất thành công');
    }
}
