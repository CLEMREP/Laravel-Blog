<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Image;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index(Request $request) : View
    {
        if (!is_null($request->get('order')) && !is_null($request->get('value'))) {
            $posts = Post::select('*')->where($request->get('order'), '=', $request->get('value'))->paginate(5);
        } else {
            if (!is_null($request->get('search_title'))) {
                $posts = Post::select('*')->where('title', 'like', '%' . $request->get('search_title') . '%')->paginate(5);
            } else {
                if (!is_null($request->get('order')) && !is_null($request->get('direction'))) {
                    $posts = Post::orderBy($request->get('order'), $request->get('direction'))->paginate(5);
                } else {
                    $posts = Post::orderBy('title', 'asc')->paginate(5);
                }
            }
        }


        return view('admin.posts', ['title' => 'Articles'], compact('posts'));
    }

    public function show(Post $post) : View
    {
        return view('post', ['post' => $post, 'title' => $post->title]);
    }

    public function create() : View
    {
        return view('admin.create', ['title' => 'Create']);
    }

    public function store(StorePostRequest $request) : RedirectResponse
    {
        /** @var array $data */
        $data = $request->validated();
        $post = Post::create($data);

        if ($request->hasFile('picture')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->picture;
            /** @var String $path */
            $path = $uploadPicture->storeAs('pictures_posts', time() . '.' . $uploadPicture->extension(), 'public');
 
            $image = new Image();
            $image->path = $path;
            $image->save();

            $post->image_id = $image->id;
            $post->save();
        };


        return redirect('/dashboard/posts');
    }


    public function edit(Post $post) : View
    {
        return view('admin.edit', ['title' => 'Edit' . ' ' . $post->title, 'post' => $post]);
    }

    public function update(UpdatePostRequest $request, Post $post) : RedirectResponse
    {
        /** @var array $data */
        $data = $request->validated();
        $post->update($data);

        if ($request->hasFile('picture')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->picture;
            /** @var String $path */
            $path = $uploadPicture->storeAs('pictures_posts', time() . '.' . $uploadPicture->extension(), 'public');
            if ($post->image) {
                /** @var string $oldPath */
                $oldPath = $post->image->path;
                $post->image->path = $path;
                $post->image->save();
                Storage::disk('public')->delete($oldPath);
            } else {
                $image = new Image();
                $image->path = $path;
                $image->save();
    
                $post->image_id = $image->id;
                $post->save();
            }
        };

        return redirect('/dashboard/posts');
    }

    public function destroy(post $post) : RedirectResponse
    {
        $post->delete();
        
        if ($post->image) {
            /** @var string $oldPath */
            $oldPath = $post->image->path;
            Storage::disk('public')->delete($oldPath);
            $post->image->delete();
        }

        return redirect('/dashboard/posts');
    }
}
