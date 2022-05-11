<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    /** @test */
    public function error_to_access_update_page_without_post()
    {
        $this->post('/posts/edit/{post}')->assertStatus(404);
    }

    /** @test */
    public function can_access_update_page()
    {
        $post = Post::factory()->create();
        $this->get(route('posts.update', ['post' => $post]))->assertSuccessful();
    }

    /** @test */
    public function post_has_been_updated()
    {
        $this->assertDatabaseCount('posts', 0);

        $post = Post::create(['title' => 'test Assert', 'content' => 'content Assert']);
        $this->post(route('posts.update', ['post' => $post]));

        $this->assertDatabaseCount('posts', 1);
    }

}