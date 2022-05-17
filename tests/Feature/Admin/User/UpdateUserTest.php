<?php

namespace Tests\Feature\Admin\User;

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
    public function can_update_user_with_admin_account()
    {
        $user = User::factory()->create(['admin' => 1]);
        $edituser = User::factory()->create(['email' => 'salut@test.com']);

        $this->actingAs($user)->post(route('admin.users.update', $edituser), ['username' => $edituser->name, 'email' => 'test@test.org'])->assertStatus(302);

        $edituser->refresh();
        $this->assertNotSame('salut@test.com', $edituser->email);
        $this->assertSame('test@test.org', $edituser->email);
    }
}
