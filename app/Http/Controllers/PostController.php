<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{
    public function index() : View
    {
        $posts = Post::orderBy('created_at')->paginate(4);
        return view('posts', ['title' => 'Articles'], compact('posts'));
    }


    public function show(Post $post) : View
    {
        return view('post', ['post' => $post]);
    }


    public function create() : View
    {
        return view('create', ['title' => 'Create']);
    }

    public function store(StorePostRequest $request) : RedirectResponse
    {
        /** @var array $data */
        $data = $request->validated();
        $post = Post::create($data);

        if ($request->hasFile('picture')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->picture;
            /** @var string $path */
            $path = $uploadPicture->storeAs('pictures_posts', time() . '.' . $uploadPicture->extension(), 'public');
 
            $image = new Image();
            $image->path = $path;
            $image->save();

            $post->image_id = $image->id;
            $post->save();
        };


        return redirect('/posts');
    }

    public function edit(Post $post) : View
    {
        return view('edit', ['title' => 'Edit', 'post' => $post]);
    }

    public function update(UpdatePostRequest $request, Post $post) : RedirectResponse
    {
        /** @var array $data */
        $data = $request->validated();
        $post->update($data);

        if ($request->hasFile('picture')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->picture;
            /** @var string $path */
            $path = $uploadPicture->storeAs('pictures_posts', time() . '.' . $uploadPicture->extension(), 'public');

            if ($post->image) {
                $oldPath = $post->image->path;
                $post->image->path = $path;
                $post->image->save();
                /** @var string $oldPath */
                Storage::disk('public')->delete($oldPath);
            } else {
                $image = new Image();
                $image->path = $path;
                $image->save();
                
                $post->image_id = $image->id;
                $post->save();
            }
        };

        return redirect('/posts');
    }
}
