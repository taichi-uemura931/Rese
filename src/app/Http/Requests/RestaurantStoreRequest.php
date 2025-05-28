<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:restaurants,name',
            'overview' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名は必須です。',
            'name.unique' => 'この店舗名はすでに使用されています。',
            'overview.required' => '概要は必須です。',
            'image.required' => '画像は必須です。',
            'image.image' => '有効な画像ファイルを選択してください。',
            'image.mimes' => '画像は jpeg, png, jpg 形式で指定してください。',
            'image.max' => '画像サイズは2MB以内にしてください。',
        ];
    }
}

