<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;

class UpdateAccountTest extends TestCase
{
    /** @test */
    public function error_to_access_update_account_page_without_login()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('account.update', ['user']))->assertStatus(302);
    }

    /** @test */
    public function can_access_update_account_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('account.update', ['user' => $user]))->assertSuccessful();
    }
}
