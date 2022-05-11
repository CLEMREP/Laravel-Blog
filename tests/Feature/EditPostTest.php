<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $post = Post::factory()->create();
        $this->get(route('posts.edit', ['post' => $post]))->assertSuccessful();
    }

    /** @test */
    public function title_and_content_are_in_edit_page()
    {
        $post = Post::factory()->create();
        $response = $this->get(route('posts.edit', ['post' => $post]));
        $response->assertSeeInOrder([$post->title, $post->content]);
    }
}
