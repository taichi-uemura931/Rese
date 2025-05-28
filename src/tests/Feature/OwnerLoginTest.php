<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class OwnerLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_login()
    {
        $owner = User::factory()->create([
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $response = $this->post('/owner/login', [
            'email' => 'owner@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
        $this->assertAuthenticatedAs($owner);
    }

    public function test_owner_login_fails_with_wrong_role()
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $response = $this->post('/owner/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
