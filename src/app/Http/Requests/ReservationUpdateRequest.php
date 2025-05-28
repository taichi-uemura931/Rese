<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateRequest extends FormRequest
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
            'number_of_people' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください。',
            'date.after_or_equal' => '日付は本日以降で指定してください。',
            'time.required' => '時間を入力してください。',
            'number_of_people.required' => '人数を入力してください。',
            'number_of_people.integer' => '人数は整数で入力してください。',
            'number_of_people.min' => '1人以上で予約してください。',
        ];
    }
}

