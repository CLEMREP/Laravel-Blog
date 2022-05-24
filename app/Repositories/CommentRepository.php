<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository
{
    public function __construct(private Comment $model)
    {
    }

    public function storeComment(array $data, array $params) : mixed
    {
        return $this->model->newQuery()
                            ->create(
                                [
                                    'content' => $data['content'],
                                    'post_id' => $params['post']->getKey(),
                                    'user_id' => $params['userComment']->getKey(),
                                ]
                            );
    }

    public function getAllUserOnPost(Post $post) : Collection
    {
        return $this->model->select('user_id')->where('post_id', $post->getKey())->distinct()->get();
    }

    public function countComment() : int
    {
        return $this->model->newQuery()->count();
    }
}
