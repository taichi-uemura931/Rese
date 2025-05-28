<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reservation;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservations = $user->reservations()
            ->with('restaurant')
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        $favorites = $user->favorites;

        return view('mypage.index', compact('user', 'reservations', 'favorites'));
    }

    public function showQrCode($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $qrUrl = route('reservation.verify', $reservation->token);
        $qrCode = QrCode::size(200)->generate($qrUrl);

        return view('mypage.verify', compact('reservation', 'qrCode'));
    }
}