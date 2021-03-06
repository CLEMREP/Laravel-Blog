<?php

namespace Tests\Feature\Admin\Post;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class EditPostTest extends TestCase
{
    /** @test */
    public function error_to_access_edit_page_without_post()
    {
        $this->get('/posts/edit/{post}')->assertStatus(404);
    }

    /** @test */
    public function can_access_edit_page()
    {
        $user = User::factory()->create(['admin' => 1]);
        $post = Post::factory()->create();

        $this->actingAs($user)->get(route('admin.posts.edit', ['post' => $post]))->assertSuccessful();
    }

    /** @test */
    public function title_and_content_are_in_edit_page()
    {
        $user = User::factory()->create(['admin' => 1]);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.posts.edit', ['post' => $post]));
        $response->assertSeeInOrder([$post->title, $post->content]);
    }
}
