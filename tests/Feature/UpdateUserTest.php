<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UpdateUserTest extends TestCase
{
    /** @test */
    public function error_to_access_update_user_page_without_user()
    {
        $user = User::factory()->create(['admin' => 1]);
        $this->actingAs($user)->post(route('admin.users.update', ['user']))->assertStatus(404);
    }

    /** @test */
    public function can_access_update_user_page()
    {
        $user = User::factory()->create(['admin' => 1]);
        $this->actingAs($user)->get(route('admin.users.update', ['user' => $user]))->assertSuccessful();
    }
}
