<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            "last_name" => ['required', 'string', 'max:8'],
            "first_name" => ['required', 'string', 'max:8'],
            "gender" => ['required'],
            "email" => ['required', 'email'],
            "front-tel" => ['required', 'numeric', 'digits_between:1,5'],
            "middle-tel" => ['required', 'numeric', 'digits_between:1,5'],
            "back-tel" => ['required', 'numeric', 'digits_between:1,5'],
            "address" => ['required'],
            "category_id" => ['required'],
            "detail" => ['required', "max:120"],
        ];
    }

    public function messages()
    {
        return [
            "last_name.required" => "姓を入力してください",
            "last_name.string" => "姓は文字列で入力してください",
            "last_name.max" => "姓は8文字以内で入力してください",
            "first_name.required" => "名を入力してください",
            "first_name.string" => "名は文字列で入力してください",
            "first_name.max" => "名は8文字以内で入力してください",
            "gender.required" => "性別を選択してください",
            "email.required" => "メールアドレスを入力してください",
            "email.email" => "メールアドレスはメール形式で入力してください",
            "front-tel.required" => "電話番号を入力してください",
            "front-tel.numeric" => "電話番号は半角数字で入力してください",
            "front-tel.digits_between" => "電話番号は5桁までの数字で入力してください",
            "middle-tel.required" => "電話番号を入力してください",
            "middle-tel.numeric" => "電話番号は半角数字で入力してください",
            "middle-tel.digits_between" => "電話番号は5桁までの数字で入力してください",
            "back-tel.required" => "電話番号を入力してください",
            "back-tel.numeric" => "電話番号は半角数字で入力してください",
            "back-tel.digits_between" => "電話番号は5桁までの数字で入力してください",
            "address.required" => "住所を入力してください",
            "category_id.required" => "お問い合わせの種類を選択してください",
            "detail.required" => "お問い合わせ内容を入力してください",
            "detail.max" => "お問い合わせ内容は120文字以内で入力してください",
        ];
    }
}
