<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function index(Request $request) : View
    {
        /** @var string $order */
        $order = $request->get('order', 'title');

        /** @var string $direction */
        $direction = $request->get('direction', 'asc');

        $filters = $request->only(['searchTitle', 'published']);
        
        $posts = $this->postRepository->allPostWithFilters($filters, $order, $direction);

        return view(
            'admin.posts',
            [
            'title' => 'Liste des articles',
            'filters' =>
            [
                ['title' => 'Alphabétique (Asc)', 'order' => 'title', 'direction' => 'asc'],
                ['title' => 'Alphabétique (Desc)', 'order' => 'title', 'direction' => 'desc'],
                ['title' => 'Date de création (Asc)', 'order' => 'created_at', 'direction' => 'asc'],
                ['title' => 'Date de création (Desc)', 'order' => 'created_at', 'direction' => 'desc'],
            ],
            ],
            compact('posts')
        );
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
        /** @var array $validated */
        $validated = $request->validated();

        /** @var User $user */
        $user = Auth::user();

        $post = $this->postRepository->storePost($validated, $user);

        if ($request->hasFile('picture')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->picture;

            /** @var string $path */
            $path = $uploadPicture->storeAs('pictures_posts', time() . '.' . $uploadPicture->extension(), 'public');

            $this->postRepository->updateOrUploadImageOnPost($post, $path);
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

        $this->postRepository->updatePost($data, $post);

        if ($request->hasFile('picture')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->picture;

            /** @var String $path */
            $path = $uploadPicture->storeAs('pictures_posts', time() . '.' . $uploadPicture->extension(), 'public');

            /** @var string|null $oldPath */
            $oldPath = $post->image?->path;

            if (isset($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $this->postRepository->updateOrUploadImageOnPost($post, $path);
        };

        return redirect('/dashboard/posts');
    }

    public function destroy(post $post) : RedirectResponse
    {
        $this->postRepository->deletePost($post);

        if ($post->image) {
            /** @var string $oldPath */
            $oldPath = $post->image->path;
            Storage::disk('public')->delete($oldPath);
            $post->image->delete();
        }

        return redirect('/dashboard/posts');
    }
}
