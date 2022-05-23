<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index(Request $request) : View
    {
        /** @var string $order */
        $order = $request->get('order', 'title');

        /** @var string $direction */
        $direction = $request->get('direction', 'asc');

        /** @var string $searchTitle */
        $searchTitle = $request->get('search_title');

        /** @var string $valuePublished */
        $valuePublished = $request->get('value');

        $query = Post::query()
                            ->orderBy($order, $direction)
                            ->when($searchTitle, function ($query, $searchTitle) {
                                $query->where('title', 'like', '%' . $searchTitle . '%');
                            });

        if(!is_null($valuePublished)) {
            $query->where($order, '=', $valuePublished);
        }
        
        $posts = $query->paginate(5);

        return view('admin.posts',
        [
            'title' => 'Liste des articles',
            'filters' =>
            [
                ['title' => 'Alphabétique (Asc)', 'order' => 'title', 'direction' => 'asc'],
                ['title' => 'Alphabétique (Desc)', 'order' => 'title', 'direction' => 'desc'],
                ['title' => 'Date de création (Asc)', 'order' => 'created_at', 'direction' => 'asc'],
                ['title' => 'Date de création (Desc)', 'order' => 'created_at', 'direction' => 'desc'],
            ],
        ], compact('posts'));
    }

    public function show(Post $post) : View
    {
        /** @var User $author */
        $author = User::find($post->user_id);

        return view('post', ['post' => $post, 'title' => $post->title, 'author' => $author->name]);
    }

    public function create() : View
    {
        return view('admin.create', ['title' => 'Create']);
    }

    public function store(StorePostRequest $request) : RedirectResponse
    {
        /** @var array $data */
        $data = $request->validated();

        /** @var User $user */
        $user = Auth::user();

        $post = Post::create(
            [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $user->id,
                'published' => $request->published,
            ]
        );

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
