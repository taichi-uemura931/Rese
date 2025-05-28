<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($reservation_id)
    {
        $reservation = Reservation::with('restaurant')
            ->where('id', $reservation_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$reservation->visited) {
            return redirect()->route('mypage')->with('error', '来店後にレビューが可能です。');
        }

        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('restaurant_id', $reservation->restaurant_id)
            ->exists();

        return view('mypage.review_form', [
            'reservation' => $reservation,
            'alreadyReviewed' => $alreadyReviewed,
        ]);
    }

    public function store(Request $request, $reservation_id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $reservation = Reservation::where('id', $reservation_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (Review::where('user_id', Auth::id())
                    ->where('restaurant_id', $reservation->restaurant_id)
                    ->exists()) {
            return redirect()->back()->with('error', 'すでにレビュー済みです。');
        }

        Review::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $reservation->restaurant_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('mypage')->with('success', 'レビューを投稿しました');
    }

    public function restaurantReviews($id)
    {
        $restaurant = \App\Models\Restaurant::with('reviews.user')->findOrFail($id);

        return view('reviews.restaurant_reviews', compact('restaurant'));
    }
}
