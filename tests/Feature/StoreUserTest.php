<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;


class StoreUserTest extends TestCase
{
    /** @test */
    public function can_store_user_in_database()
    {
        $user = User::factory()->create(['admin' => 1]);
        $this->assertDatabaseCount('users', 1);

        $this->actingAs($user)->post(
            route('admin.users.store'), 
            [
                'username' => 'Luigi',
                'email' => 'luigi@test.fr',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        )
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('users', 2);
    }
}
