<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCommentPostNotification;

class CommentController extends Controller
{
    public function __construct(private CommentRepository $commentRepository, private UserRepository $userRepository)
    {
    }
    public function store(StoreCommentRequest $request, Post $post) : RedirectResponse
    {
        /** @var Post $post */
        $post = $request->post;

        /** @var User $userComment */
        $userComment = Auth::user();

        /** @var array $validated */
        $validated = $request->validated();

        $this->commentRepository->storeComment($validated, $post, $userComment);

        $data =
        [
            'username_comment' => $userComment->name,
            'post_title' => $post->title,
            'post_id' => $post->getKey()
        ];


        $userIdCol = $this->commentRepository->getAllUserIdOnPost($post);

        $userCol = $this->userRepository->getUsersOnComment($userIdCol);
        $userCol->push($post->author);

        Notification::send($userCol, new UserCommentPostNotification($data));

        return redirect(route('posts.show', $post));
    }
}
