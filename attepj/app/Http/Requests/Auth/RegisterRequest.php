<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:Users,email',
            'password' => 'required|confirmed|between:8,191',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '名前は数値以外で入力してください',
            'name.max' => '名前は191文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.string' => 'メールアドレスは数値以外で入力してください',
            'email.max' => 'メールアドレスは191文字以内で入力してください',
            'email.unique' => 'このメールアドレスは既に登録されている為、登録できません',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードと確認用パスワードは一致させてください',
            'password.between' => 'パスワードは8文字以上、191文字以内で入力してください',
        ];
    }
}
