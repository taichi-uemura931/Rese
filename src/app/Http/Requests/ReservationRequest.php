<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'number_of_people' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください。',
            'date.after_or_equal' => '予約日は今日以降の日付を指定してください。',
            'time.required' => '時間を入力してください。',
            'number_of_people.required' => '人数を入力してください。',
        ];
    }

    public function redirectTo()
    {
        return route('shop.detail', ['id' => $this->restaurant_id]);
    }
}

