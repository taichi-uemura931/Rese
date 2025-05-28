<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;

class ShopController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with(['areas', 'genres'])->get();
        $areas = Area::all();
        $genres = Genre::all();

        return view('shop.index', compact('restaurants', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        $query = Restaurant::with(['areas', 'genres']);

        if ($request->filled('area')) {
            $query->whereHas('areas', function ($q) use ($request) {
                $q->where('areas.id', $request->area);
            });
        }

        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('overview', 'like', '%' . $request->keyword . '%');
        }

        $restaurants = $query->get();
        $areas = Area::all();
        $genres = Genre::all();

        return view('shop.index', compact('restaurants', 'areas', 'genres'));
    }

    public function detail($id)
    {
        $restaurant = Restaurant::with(['areas', 'genres'])->findOrFail($id);
        return view('shop.detail', compact('restaurant'));
    }

    public function reserve(ReservationRequest $request)
    {
        $data = $request->validated();

        Reservation::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $data['restaurant_id'],
            'date' => $data['date'],
            'time' => $data['time'],
            'number_of_people' => $data['number_of_people'],
        ]);

        return redirect()->route('done')->with('success', '予約が完了しました');
    }

    public function stripeSuccess(Request $request)
    {
        return redirect()->route('thanks');
    }
}
