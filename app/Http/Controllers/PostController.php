<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function show(Profile $profile, Post $post)
    {
        $post->load([
            'profile',
            'repostOf.profile',
            'replies' => function ($q) {
                $q->withCount(['likes', 'replies', 'reposts'])
                    ->with([
                        'profile',
                        // only load parent if exists (no deep recursion here)
                        'parent' => function ($q) {
                            $q->with('profile');
                        },
                        // nested replies (1 level deep)
                        'replies' => function ($q) {
                            $q->withCount(['likes', 'replies', 'reposts'])
                                ->with('profile');
                        },
                    ])
                    ->oldest();
            }
        ])->loadCount(['likes', 'replies', 'reposts']);

        return view('posts.show', compact('profile', 'post'));
    }

}
