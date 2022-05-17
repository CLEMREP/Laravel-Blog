<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use Illuminate\Http\Request;

class OnlyPublishedPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Post $post */
        $post = $request->post;
        if (!($post->published)) {
            abort(404);
        }
        return $next($request);
    }
}
