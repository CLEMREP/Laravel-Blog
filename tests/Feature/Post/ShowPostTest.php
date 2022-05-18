<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Comment;

class ShowPostTest extends TestCase
{
    /** @test */
    public function comment_is_in_show_page()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['content' => 'Ton article est génial !', 'post_id' => $post->getKey()]);

        $response = $this->get(route('posts.show', $post))->assertSuccessful();
        $response->assertSeeText('Ton article est génial !');
    }
}
