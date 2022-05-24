<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository 
{
    public function __construct(private Post $model)
    {
    }

    public function allPostWithFilters(array $filters, string $order, string $direction) : LengthAwarePaginator
    {

        /** @var string|null $searchTitle */
        $searchTitle = $filters['search_title'] ?? null;

        /** @var string|null $valuePublished */
        $valuePublished = $filters['value'] ?? null;

        $query = $this->model->newQuery()
                            ->orderBy($order, $direction)
                            ->when($searchTitle, function ($query) use ($searchTitle) {
                                $query->where('title', 'like', '%' . $searchTitle . '%');
                            })
                            ->when(!is_null($valuePublished), function ($query) use ($valuePublished, $order) {
                                $query->where($order, '=', $valuePublished);
                            });;
        
        $posts = $query->paginate(5);

        return $posts;
    }

    public function publishedPost() : LengthAwarePaginator
    {
        return $this->model->newQuery()->where('published', 1)->orderBy('created_at')->paginate(5);
    }

    public function storePost(array $data, User $user) : Post
    {
        return $this->model->create(
            [
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => $user->id,
                'published' => $data['published'],
            ]
        );
    }

    public function updatePost(array $data, Post $post) : mixed
    {
        return $this->model->newQuery()
                            ->where('id', $post->id)
                            ->update($data);
    }

    public function deletePost(Post $post) : mixed
    {
        return $this->model->newQuery()
                            ->where('id', $post->id)
                            ->delete();
    }

    public function countPost() : int
    {
        return $this->model->newQuery()->count();
    }
}

?>