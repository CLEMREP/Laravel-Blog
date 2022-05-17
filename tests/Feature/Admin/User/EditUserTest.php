<?php

namespace Tests\Feature\Admin\User;


use Tests\TestCase;
use App\Models\User;

class EditUserTest extends TestCase
{
    /** @test */
    public function can_access_user_edit_page()
    {
        $user = User::factory()->create(['admin' => 1]);
        $this->actingAs($user)->get(route('admin.users.edit', ['user' => $user]))
        ->assertSuccessful();
    }

    /** @test */
    public function username_and_email_are_in_edit_page()
    {
        $user = User::factory()->create(['admin' => 1]);

        $response = $this->actingAs($user)->get(route('admin.users.edit', ['user' => $user]));
        $response->assertSeeInOrder([$user->name, $user->email]);
    }
}
