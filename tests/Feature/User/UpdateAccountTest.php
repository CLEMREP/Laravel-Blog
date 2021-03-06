<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;

class UpdateAccountTest extends TestCase
{
    /** @test */
    public function can_access_update_account_page_with_login()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('account.update'), ['username' => 'test', 'email' => 'test@test.com'])->assertRedirect(route('account.edit'));

        $this->assertSame('test', $user->name);
        $this->assertSame('test@test.com', $user->email);
    }

    /** @test */
    public function error_to_access_update_account_page_without_login()
    {
        $this->post(route('account.update'))->assertRedirect(route('login'));
    }
}
