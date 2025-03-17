<?php

namespace App\Http\Controllers;

use App\Models\Post;

use App\Http\Resources\PostResource;

class PostEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        return inertia('posts/Edit', [
            'currentPost' => new PostResource($post)
        ]);
    }
}
