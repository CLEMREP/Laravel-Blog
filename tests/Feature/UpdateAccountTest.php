<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UpdateAccountTest extends TestCase
{
    /** @test */
    public function error_to_access_update_account_page_without_login()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('admin.account.update', ['user']))->assertStatus(302);
    }

    /** @test */
    public function can_access_update_account_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('admin.account.update', ['user' => $user]))->assertSuccessful();
    }
}
