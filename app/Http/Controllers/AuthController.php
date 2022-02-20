<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\TwoFactorAuthPassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * ログインページ表示
     */
    public function getLogin()
    {
        return view('auth.login');
        // return view('auth.login-auth-second');
    }

    /**
     * ログイン処理
     */
    public function postLogin(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * 1段階目認証
     */
    public function first_auth(LoginRequest $request) {
        // バリデーションチェック
        $request->authenticate();

        // 認証パスワード生成
        $random_password = '';

        for($i = 0; $i < 4; $i++) {
            $random_password .= strval(rand(0,9));
        }

        $user = User::where('email', $request->email)->first();
        $user->tfa_token = $random_password;    // 4桁のランダム数字
        $user->tfa_expiration = now()->addMinutes(10);  // 10分間有効にする
        $user->save();

        // メール送信
        \Mail::to($user)->send(new TwoFactorAuthPassword($random_password));

        $param = [
            'result' => true,
            'user_id' => $user->id
        ];

        return $param;
    }

    /**
     * 2段階目認証
     */
    public function second_auth(Request $request) {
        $result = false;

        if($request->filled('tfa_token', 'user_id')) {
            $user = User::find($request->user_id);
            $expiration = new Carbon($user->tfa_expiration);

            if($user->tfa_token === $request->tfa_token && $expiration > now()) {
                $user->tfa_token == null;
                $user->tfa_expiration == null;
                $user->save();

                Auth::login($user);
                $result = true;
            }
        }

        return ['result' => $result];
    }

    /**
     * 会員登録ページ表示
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * 会員登録処理
     */
    public function postRegister(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }

    /**
     * ログアウト処理
     */
    public function getLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
