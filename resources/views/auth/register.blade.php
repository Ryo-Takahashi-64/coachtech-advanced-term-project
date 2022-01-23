@extends('default.index')

@push('css')
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush

@section('content')
    <div class="pt-20 w-2/5 mx-auto content__item">
        <h2 class="text-center text-xl font-bold">会員登録</h2>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <!-- Name -->
            <div class="mt-10">
                <x-input id="name" type="text" name="name" placeholder="名前" :value="old('name')" required autofocus />
                <!-- Validation Errors -->
                @if($errors->has('name'))
                    <p class="text-red-600">{{$errors->first('name')}}</p>
                @endif
            </div>

            <!-- Email Address -->
            <div class="mt-6">
                <x-input id="email" type="email" name="email" placeholder="メールアドレス" :value="old('email')" required />
                <!-- Validation Errors -->
                @if($errors->has('email'))
                    <p class="text-red-600">{{$errors->first('email')}}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="mt-6">
                <x-input id="password" type="password" name="password" placeholder="パスワード" required autocomplete="new-password" />
                <!-- Validation Errors -->
                @if($errors->has('password'))
                    <p class="text-red-600">{{$errors->first('password')}}</p>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="mt-6">
                <x-input id="password_confirmation" type="password" name="password_confirmation" placeholder="確認用パスワード" required />
            </div>

            <x-button>
                {{ __('会員登録') }}
            </x-button>

            <div class="text-center mt-6">
                <p class="text-gray-400">アカウントをお持ちの方はこちらから</p>
                <a href="/login" class="text-blue-700 font-bold">ログイン</a>
            </div>

        </form>
    </div>
@endsection