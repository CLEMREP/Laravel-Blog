<?php

namespace App\Repositories;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;

class PostRepository 
{
    public function __construct(private Post $model)
    {
    }

    public function allPostWithFilters($order, $direction, $searchTitle, $valuePublished)
    {
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

    public function storePost(StorePostRequest $request, $user)
    {
        return $this->model->create(
            [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $user->id,
                'published' => $request->published,
            ]
        );
    }

    public function updatePost($data, $post)
    {
        return $this->model->newQuery()
                            ->where('id', $post->id)
                            ->update($data);
    }
}

?>