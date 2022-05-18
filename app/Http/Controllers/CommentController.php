<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCommentPostNotification;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post) : RedirectResponse
    {
        /** @var Post $post */
        $post = $request->post;

        /** @var User $userComment */
        $userComment = Auth::user();

        $request->validated();

        Comment::create([
            'content' => $request->content,
            'post_id' => $post->getKey(),
            'user_id' => $userComment->getKey(),
        ]);

        $data =
        [
            'username_comment' => $userComment->name,
            'post_title' => $post->title,
            'post_id' => $post->getKey()
        ];

        $userIdCol = Comment::select('user_id')->where('post_id', $post->getKey())->distinct()->get();
        $userCol = User::whereIn('id', $userIdCol)->get();
        $userCol->push($post->author);

        Notification::send($userCol, new UserCommentPostNotification($data));

        return redirect(route('posts.show', $post));
    }
}
