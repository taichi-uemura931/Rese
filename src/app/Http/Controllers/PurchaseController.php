<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function purchase(ReservationRequest $request)
    {
        $data = $request->validated();

        Reservation::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $request->restaurant_id,
            'date' => $request->date,
            'time' => $request->time,
            'number_of_people' => $request->number_of_people,
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => 5000,
                    'product_data' => [
                        'name' => 'コース予約',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            'success_url' => route('done'),

            'cancel_url' => route('shop.detail', ['id' => $request->restaurant_id]),
        ]);

        return redirect($session->url);
    }
}
