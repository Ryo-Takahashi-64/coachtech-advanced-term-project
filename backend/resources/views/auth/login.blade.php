@extends('default.index')

@push('css')
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush

@section('content')
    <div id="app" class="pt-20 w-2/5 mx-auto content__item">

        <h2 class="text-center text-xl font-bold">ログイン</h2>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- １段階目のログインフォーム -->
        <div v-if="step==1">
            <!-- Email Address -->
            <div class="mt-10">
                <x-input id="email" type="email" name="email" v-model="email" placeholder="メールアドレス" :value="old('email')" required autofocus />
                <!-- Validation Errors -->
                <p class="text-red-600" v-if="message['email']" v-text="message['email'][0]"></p>
            </div>

            <!-- Password -->
            <div class="mt-6">
                <x-input id="password" type="password" name="password" v-model="password" placeholder="パスワード" required autocomplete="current-password" />
                <!-- Validation Errors -->
                <p class="text-red-600" v-if="message['password']" v-text="message['password'][0]"></p>
            </div>

            <x-button @click="firstAuth">
                {{ __('ログイン') }}
            </x-button>

            <div class="text-center mt-6">
                <p class="text-gray-400">アカウントをお持ちでない方はこちらから</p>
                <a href="/register" class="text-blue-700 font-bold">会員登録</a>
            </div>
        </div>

        <!-- ２段階目・ログインフォーム -->
        <div v-if="step==2">
            ２段階認証のパスワードをメールアドレスに登録しました。（有効時間：10分間）
            <x-input id="token" type="text" name="token" v-model="token" placeholder="パスワード" required />
            <x-button @click="secondAuth">
                {{ __('送信する') }}
            </x-button>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script>

        new Vue({
            el: '#app',
            data: {
                step: 1,
                email: '',
                password: '',
                token: '',
                userId: -1,
                message: '',
            },
            methods: {
                firstAuth() {

                    this.message = '';

                    const url = '/first_auth';
                    const params = {
                        email: this.email,
                        password: this.password
                    };
                    axios.post(url, params)
                        .then(response => {

                            const result = response.data.result;

                            if(result) {
                                this.userId = response.data.user_id;
                                this.step = 2;
                            } else {
                                this.message = 'ログイン情報に誤りがあります。';
                            }
                        })
                        .catch(e => {
                            this.message = e.response.data.errors;
                        });

                },
                secondAuth() {

                    const url = '/second_auth';
                    const params = {
                        user_id: this.userId,
                        tfa_token: this.token
                    };

                    axios.post(url, params)
                        .then(response => {

                            const result = response.data.result;

                            if(result) {
                                // ２段階認証成功
                                location.href = '/';
                            } else {
                                this.message = '２段階パスワードが正しくありません。';
                                this.token = '';
                            }
                        });
                }
            }
        });

    </script>
@endpush
