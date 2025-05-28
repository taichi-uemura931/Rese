<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationVerificationController extends Controller
{
    public function verify($token)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        if ($reservation->visited) {
            return view('mypage.verify', ['message' => 'すでに来店済みです']);
        }

        $reservation->visited = true;
        $reservation->save();

        return view('mypage.result', ['message' => '来店を確認しました']);
    }
}
