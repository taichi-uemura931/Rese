<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class OwnerReservationController extends Controller
{
    public function index()
    {
        $ownerRestaurantIds = Auth::user()->restaurants->pluck('id');

        $reservations = Reservation::with(['restaurant', 'user'])
            ->whereIn('restaurant_id', $ownerRestaurantIds)
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('owner.reservations.index', compact('reservations'));
    }

    public function verifyQr($token)
    {
        $reservation = Reservation::where('token', $token)
            ->with('user', 'restaurant')
            ->first();

        if (!$reservation) {
            return view('owner.verify_result')->with('message', '予約が見つかりません。');
        }

        if ($reservation->restaurant->owner_id !== Auth::id()) {
            abort(403, '認可されていません');
        }

        if ($reservation->visited) {
            return view('owner.verify_result')->with('message', 'この予約はすでに来店済みです。');
        }

        $reservation->visited = true;
        $reservation->save();

        return view('owner.verify_result')->with('message', '来店確認が完了しました！');
    }

    public function toggleVisited($id)
    {
        $reservation = Reservation::where('id', $id)
            ->whereHas('restaurant', function ($query) {
                $query->where('owner_id', Auth::id());
            })
            ->firstOrFail();

        $reservation->visited = !$reservation->visited;
        $reservation->save();

        return redirect()->back()->with('success', '来店状態を変更しました。');
    }

    public function cancel($id)
    {
        $reservation = Reservation::with('restaurant')
            ->where('id', $id)
            ->whereHas('restaurant', function ($query) {
                $query->where('owner_id', Auth::id());
            })
            ->firstOrFail();

        $reservation->canceled = true;
        $reservation->save();

        return redirect()->route('owner.reservations.index')->with('success', '予約をキャンセルしました');
    }
}
