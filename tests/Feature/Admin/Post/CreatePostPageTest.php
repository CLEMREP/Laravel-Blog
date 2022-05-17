<?php

namespace Tests\Feature\Admin\Post;

use Tests\TestCase;
use App\Models\User;

class CreatePostPageTest extends TestCase
{
    /** @test */
    public function can_access_post_create_form()
    {

        $user = User::factory()->create(['admin' => 1]);

        $this->actingAs($user)->get(route('admin.posts.create'))->assertSuccessful();
    }
}
