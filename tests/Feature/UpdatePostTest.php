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
        $this->post(route('posts.update', ['post']))->assertStatus(404);
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
        $post = Post::factory()->create();
        $this->post(route('posts.update', ['post' => $post]), ['title' => 'Bonsoir !', 'content' => 'Comment vous allez ?']);
        $post->refresh();

        $this->assertEquals($post->title, "Bonsoir !");
        $this->assertEquals($post->content, "Comment vous allez ?");
    }

}