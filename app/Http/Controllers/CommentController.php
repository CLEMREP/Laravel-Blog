<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post) : RedirectResponse
    {
        /** @var Post $post */
        $post = $request->post;

        $request->validated();

        Comment::create([
            'content' => $request->content,
            'post_id' => $post->getKey(),
        ]);

        return redirect(route('posts.show', $post));
    }
}
