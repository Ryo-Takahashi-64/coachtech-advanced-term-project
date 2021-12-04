<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
    }

    /**
     * ログイン処理
     */
    public function postLogin(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return view('stamp');
        return redirect('/');
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
