@component('mail::message')
# {{ $reservation->user->name }}様

本日、以下のご予約があります。

- 店舗名：**{{ $reservation->restaurant->name }}**
- 日時：**{{ $reservation->date }} {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}**
- 人数：**{{ $reservation->number_of_people }}人**

お忘れのないようご来店くださいませ。

@component('mail::button', ['url' => route('mypage')])
マイページを確認する
@endcomponent

{{ config('app.name') }} より
@endcomponent
