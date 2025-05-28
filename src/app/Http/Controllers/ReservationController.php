<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function edit($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('reservations.edit', compact('reservation'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->delete();

        return redirect()->route('mypage')->with('success', '予約をキャンセルしました');
    }

    public function update(ReservationUpdateRequest $request, $id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->update($request->validated());

        return redirect()->route('mypage')->with('success', '予約内容を更新しました');
    }

}
