<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class StoreCommentTest extends TestCase
{
    /** @test */
    public function can_store_comment_on_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseCount('comments', 0);

        $this->actingAs($user)->post(
            route('comments.store', $post), 
            [
                'content' => 'Ton article est génial !',
            ]
        )
        ->assertRedirect(route('posts.show', $post))
        ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('comments', 1);
        
        $this->assertSame($post->getKey(), Comment::find(1)->getKey());
    }

    /** @test */
    public function comment_is_in_view_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)->post(
            route('comments.store', $post), 
            [
                'content' => 'Ton article est génial !',
            ]
        )
        ->assertRedirect(route('posts.show', $post))
        ->assertSessionHasNoErrors();


        $response = $this->get(route('posts.show', $post));
        $response->assertSeeText('Ton article est génial !');
    }
}
