<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

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
        $valuePublished = $filters['published'] ?? null;

        $query = $this->model->newQuery()
                            ->orderBy($order, $direction)
                            ->when($searchTitle, function ($query) use ($searchTitle) {
                                $query->where('title', 'like', '%' . $searchTitle . '%');
                            })
                            ->when(isset($valuePublished), function ($query) use ($valuePublished) {
                                $query->where('published', '=', $valuePublished);
                            });
        ;
        
        return $query->paginate(5);
    }

    public function publishedPost() : LengthAwarePaginator
    {
        return $this->model->newQuery()
                            ->where('published', true)
                            ->orderBy('created_at')
                            ->paginate(5);
    }

    public function storePost(array $data, User $user) : Post
    {
        return $this->model->create(
            [
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => $user->getKey(),
                'published' => $data['published'],
            ]
        );
    }

    public function updatePost(array $data, Post $post) : bool
    {
        return $post->update($data);
    }

    public function deletePost(Post $post) : bool|null
    {
        return $post->delete();
    }

    public function uploadImageOnPost(Post $post, string $path) : void
    {
        $image = $post->image ?? new Image();
        $image->path = $path;
        $image->save();

        $post->image_id = $image->id;
        $post->save();
    }

    public function updateImageOnPost(Post $post, string $path) : void
    {
        if ($post->image) {
            $post->image->path = $path;
            $post->image->save();
        } else {
            $image = new Image();
            $image->path = $path;
            $image->save();

            $post->image_id = $image->id;
            $post->save();
        }
    }

    public function countPost() : int
    {
        return $this->model->newQuery()->count();
    }
}
