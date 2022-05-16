<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at')->paginate(4);
        return view('admin.posts', ['title' => 'Articles'], compact('posts'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post', ['post' => $post, 'title' => $post->title]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create', ['title' => 'Create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        /** @var array $data */
        $data = $request->validated();
        $post = Post::create($data);

        if($request->hasFile('picture')){
            $path = $request->file('picture')->storeAs('pictures_posts', time() . '.' . $request->picture->extension(), 'public');
 
            $image = new Image();
            $image->path = $path;
            $image->save();

            $post->image_id = $image->getKey();
            $post->save();
        };


        return redirect('/dashboard/posts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.edit', ['title' => 'Edit' . ' ' . $post->title, 'post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        /** @var array $data */
        $data = $request->validated();
        $post->update($data);

        if($request->hasFile('picture')){
            $path = $request->file('picture')->storeAs('pictures_posts', time() . '.' . $request->picture->extension(), 'public');
            if ($post->image) {
                $oldPath = $post->image->path;
                $post->image->path = $path;
                $post->image->save();
                Storage::disk('public')->delete($oldPath);
            } else {
                $image = new Image();
                $image->path = $path;
                $image->save();
    
                $post->image_id = $image->getKey();
                $post->save();
            }

        };

        return redirect('/dashboard/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        $post->delete();
        
        if ($post->image) {
            Storage::disk('public')->delete($post->image->path);
            $post->image->delete();
        }

        return redirect('/dashboard/posts');
    }
}