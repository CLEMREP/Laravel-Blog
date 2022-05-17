<?php

namespace Tests\Feature\Admin\Post;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class DeletePostTest extends TestCase
{
    /** @test */
    public function try_to_delete_post_without_login() {
        $post = Post::factory()->create();
        $this->assertDatabaseCount('posts', 1);
        $this->post(route('admin.posts.destroy', $post))->assertRedirect();
        $this->assertDatabaseCount('posts', 1);
    }
    
    /** @test */
    public function can_delete_post()
    {
        $user = User::factory()->create(['admin' => 1]);
        $post = Post::factory()->create();

        $this->assertDatabaseCount('posts', 1);

        $this->actingAs($user)->post(route('admin.posts.destroy', $post));

        $this->assertDatabaseCount('posts', 0);
    }
}
