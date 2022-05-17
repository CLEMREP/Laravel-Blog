<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class IndexUserTest extends TestCase
{
    /** @test */
    public function only_admin_can_access_index_user()
    {
        $user = User::factory()->create(['admin' => 1]);

        $this->actingAs($user)->get(route('admin.users.index'))->assertSuccessful();
    }

    /** @test */
    public function count_number_of_users_between_array_and_database()
    {
        $users = User::factory()->count(3)->create(['admin' => 1]);

        $reponse = $this->actingAs($users[1])->get(route('admin.users.index'));
        $data = $reponse->viewData("users");

        $this->assertCount(3, $data);

        for($i=0; $i < sizeof($users); $i++) {
            $this->assertSame($users[$i]["id"], $data[$i]["id"]);
        }
    }
}
