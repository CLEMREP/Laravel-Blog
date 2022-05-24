<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CommentRepository;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

class DashboardController extends Controller
{
    public function __construct(private PostRepository $postRepository, private UserRepository $userRepository, private CommentRepository $commentRepository)
    {
    }
    
    public function index() : View
    {
        return view('dashboard', [
            'totalUsers' => $this->userRepository->countUser(),
            'totalPosts' => $this->postRepository->countPost(),
            'totalComments' => $this->commentRepository->countComment(),
        ]);
    }
}
