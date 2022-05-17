<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;

class EditAccountTest extends TestCase
{
    /** @test */
    public function can_access_user_account_page()
    {
        $user = User::factory()->create(['admin' => 1]);
        $this->actingAs($user)->get(route('account.edit', ['user' => $user]))
        ->assertSuccessful();
    }

    /** @test */
    public function username_and_email_are_in_account_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('account.edit', ['user' => $user]));
        $response->assertSeeInOrder([$user->name, $user->email]);
    }
}
