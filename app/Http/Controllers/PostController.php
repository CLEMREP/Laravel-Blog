<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index() : View
    {
        $posts = Post::where('published', 1)->orderBy('created_at')->paginate(4);
        return view('posts', ['title' => 'Articles'], compact('posts'));
    }


    public function show(Post $post) : View
    {
        if ($post->published) { // Avec Middleware
            return view('post', ['post' => $post, 'title' => $post->title]);
        } else {
            abort(404);
        }
    }
}
