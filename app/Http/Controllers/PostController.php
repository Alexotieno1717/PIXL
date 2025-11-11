<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\TimelineQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return view('posts.index', compact('posts', 'profile'));

    }

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

    public function store(CreatePostRequest $request)
    {
        $profile = Auth::user()->profile;

        $post = Post::publish($profile, $request->content);

        return redirect(route('posts.index'));
    }

    public function reply(Profile $profile, Post $post, CreatePostRequest $request)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::reply($currentProfile, $post, $request->content);

        return redirect(route('posts.index'));
    }


}
