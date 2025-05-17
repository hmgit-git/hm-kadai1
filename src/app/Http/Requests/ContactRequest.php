<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ← ここを true にしないと403になるので注意！
    }

    public function rules()
    {
        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'gender' => 'required|in:1,2,3',
            'email' => 'required|email',
            'tel1' => 'required|digits:3',
            'tel2' => 'required|digits:4',
            'tel3' => 'required|digits:4',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => '姓を入力してください。',
            'first_name.required' => '名を入力してください。',
            'gender.required' => '性別を選択してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'tel1.required' => '電話番号を入力してください。',
            'tel2.required' => '電話番号を入力してください。',
            'tel3.required' => '電話番号を入力してください。',
            'address.required' => '住所を入力してください。',
            'category_id.required' => 'お問い合わせ種別を選択してください。',
            'detail.required' => 'お問い合わせ内容を入力してください。',
        ];
    }
}
