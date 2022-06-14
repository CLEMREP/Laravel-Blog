<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository
{
    public function __construct(private Comment $model)
    {
    }

    public function storeComment(array $data, Post $post, User $author) : mixed
    {
        return $this->model->newQuery()
                            ->create(
                                [
                                    'content' => $data['content'],
                                    'post_id' => $post->getKey(),
                                    'user_id' => $author->getKey(),
                                ]
                            );
    }

    public function getAllUserIdOnPost(Post $post) : Collection
    {
        return $this->model
                    ->select('user_id')
                    ->where('post_id', $post->getKey())
                    ->distinct()
                    ->get();
    }

    public function countComment() : int
    {
        return $this->model->newQuery()->count();
    }
}
