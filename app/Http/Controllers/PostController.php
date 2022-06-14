<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    public function __construct(private PostRepository $postRepository)
    {
    }
    
    public function index() : View
    {
        $posts = $this->postRepository->publishedPost();
        return view('posts', ['title' => 'Articles', 'posts' => $posts]);
    }


    public function show(Post $post) : View
    {
        return view('post', ['post' => $post, 'title' => $post->title]);
    }
}
