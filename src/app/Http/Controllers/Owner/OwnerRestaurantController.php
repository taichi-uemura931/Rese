<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\RestaurantStoreRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use Illuminate\Support\Facades\Auth;

class OwnerRestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::where('owner_id', Auth::id())->get();
        return view('owner.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner.restaurants.create', compact('areas', 'genres'));
    }

    public function store(RestaurantStoreRequest $request)
    {
        $imagePath = $request->file('image')->store('images', 'public');

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'overview' => $request->overview,
            'image' => $imagePath,
            'owner_id' => Auth::id(),
        ]);

        $restaurant->areas()->sync([$request->area_id]);

        $restaurant->genres()->sync($request->genre_ids);

        return redirect()->route('owner.restaurants.index')->with('success', '店舗を作成しました');
    }

    public function edit($id)
    {
        $restaurant = Restaurant::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();
        $areas = Area::all();
        $genres = Genre::all();

        return view('owner.restaurants.edit', compact('restaurant', 'areas', 'genres'));
    }

    public function update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $restaurant->image = $imagePath;
        }

        $restaurant->name = $request->name;
        $restaurant->overview = $request->overview;
        $restaurant->save();

        return redirect()->route('owner.restaurants.index')->with('success', '店舗情報を更新しました');
    }

    public function reviews($id)
    {
        $restaurant = Restaurant::where('id', $id)
            ->where('owner_id', Auth::id())
            ->firstOrFail();

        $reviews = Review::with('user')
            ->where('restaurant_id', $restaurant->id)
            ->latest()
            ->get();

        return view('owner.restaurants.reviews', compact('restaurant', 'reviews'));
    }
}
