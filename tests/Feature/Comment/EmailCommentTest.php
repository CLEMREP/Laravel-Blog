<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Notifications\UserCommentPostNotification;
use Illuminate\Support\Facades\Notification;

class EmailCommentTest extends TestCase
{
    /** @test */
    public function email_has_been_sent()
    {
        Notification::fake();

        $user = User::factory()->create();
        $post = Post::factory()->create();
        Comment::factory()->create(['post_id' => $post->getKey(), 'user_id' => $user->getKey()]);

        $this->actingAs($user)->post(
            route('comments.store', $post), 
            [
                'content' => 'Ton article est génial !',
            ]
        )
        ->assertRedirect(route('posts.show', $post))
        ->assertSessionHasNoErrors();


        $userIdCol = Comment::select('user_id')->where('post_id', $post->getKey())->distinct()->get();
        $userCol = User::whereIn('id', $userIdCol)->get();
        $userCol->push($post->author);

        Notification::assertSentTo($userCol, UserCommentPostNotification::class);
    }
}
