<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() : View
    {
        return view('dashboard', [
            'totalUsers' => DB::table('users')->count(),
            'totalPosts' => DB::table('posts')->count(),
            'totalComments' => DB::table('comments')->count(),
        ]);
    }
}
