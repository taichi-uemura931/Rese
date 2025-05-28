<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Restaurant $restaurant)
    {
        $user = auth()->user();

        if ($user->favorites()->where('restaurant_id', $restaurant->id)->exists()) {
            $user->favorites()->detach($restaurant->id);
        } else {
            $user->favorites()->attach($restaurant->id);
        }

        return response()->json(['status' => 'ok']);
    }
}
