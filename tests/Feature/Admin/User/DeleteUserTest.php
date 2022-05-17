<?php

namespace Tests\Feature\Admin\User;

use Tests\TestCase;
use App\Models\User;

class DeleteUserTest extends TestCase
{
    /** @test */
    public function try_to_delete_user_without_admin_user() {
        $user = User::factory()->create();

        $this->assertDatabaseCount('users', 1);
        $this->post(route('admin.users.destroy', $user))->assertRedirect();
        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function can_delete_user()
    {
        $user = User::factory()->create(['admin' => 1]);

        $this->assertDatabaseCount('users', 1);

        $this->actingAs($user)->post(route('admin.users.destroy', $user));

        $this->assertDatabaseCount('users', 0);
    }
}
