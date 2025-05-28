<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_view_reservation_list()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $owner->id]);
        Reservation::factory()->create(['restaurant_id' => $restaurant->id]);

        $response = $this->actingAs($owner)->get(route('owner.reservations.index'));

        $response->assertStatus(200);
        $response->assertSee('予約一覧');
    }

    public function test_qr_verification_marks_reservation_as_visited()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $owner->id]);
        $reservation = Reservation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'visited' => false,
            'token' => \Str::uuid(),
        ]);

        $response = $this->actingAs($owner)->get(route('owner.verify.qr', ['token' => $reservation->token]));

        $response->assertStatus(200);
        $response->assertSee('来店確認が完了しました');
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'visited' => true,
        ]);
    }

    public function test_qr_verification_with_invalid_token()
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $response = $this->actingAs($owner)->get(route('owner.verify.qr', ['token' => 'invalid-token']));

        $response->assertStatus(200);
        $response->assertSee('予約が見つかりません');
    }

    public function test_qr_verification_with_already_visited_reservation()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $owner->id]);
        $reservation = Reservation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'visited' => true,
        ]);

        $response = $this->actingAs($owner)->get(route('owner.verify.qr', ['token' => $reservation->token]));

        $response->assertStatus(200);
        $response->assertSee('この予約はすでに来店済みです');
    }

    public function test_owner_can_toggle_visited_status()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $owner->id]);
        $reservation = Reservation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'visited' => false,
            'token' => \Str::uuid(),
        ]);

        $response = $this->actingAs($owner)
            ->post(route('owner.reservations.toggleVisited', $reservation->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'visited' => true,
        ]);
    }

    public function test_non_owner_cannot_toggle_visited_status()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $otherOwner = User::factory()->create(['role' => 'owner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $otherOwner->id]);
        $reservation = Reservation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'visited' => false,
            'token' => \Str::uuid(),
        ]);

        $response = $this->actingAs($owner)->post(
            route('owner.reservations.toggleVisited', $reservation->id)
        );

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'visited' => false,
        ]);
    }
}
