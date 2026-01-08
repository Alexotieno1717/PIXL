<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\PostThreadQuery;
use App\Queries\TimelineQuery;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function index()
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return Inertia::render('Posts/Index', [
            'profile' => $profile->toResource(),
            'posts' => $posts->toResourceCollection(),
        ]);

    }

    //
    public function show(Profile $profile, Post $post)
    {
        $post = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return view('posts.show', compact('profile', 'post'));
    }

    public function store(CreatePostRequest $request)
    {
        $profile = Auth::user()->profile;

        $post = Post::publish($profile, $request->content);

        return to_route('posts.index');
    }

    public function reply(Profile $profile, Post $post, CreatePostRequest $request)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::reply($currentProfile, $post, $request->content);

        return to_route('posts.index');
    }

    public function repost(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::repost($currentProfile, $post);

        return to_route('posts.index');
    }

    public function quote(Profile $profile, Post $post, CreatePostRequest $request)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::repost($currentProfile, $post, $request->content);

        return to_route('posts.index');
    }

    public function like(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        Like::createLike($currentProfile, $post);

        return back();
    }

    public function unlike(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        Like::removeLike($currentProfile, $post);

        return back();
    }

    public function destroy(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;
        $success = false;

        if ($currentProfile->id === $profile->id) {
            $success = $post->delete() > 0;

            return response()->json(compact('success'));
        }

        $repost = $post->reposts()->where('profile_id', $currentProfile->id)->first();

        if (! is_null($repost)) {
            $success = $post->delete() > 0;

            return response()->json(compact('success'));
        }

        return response()->json(compact('success'));
    }
}
