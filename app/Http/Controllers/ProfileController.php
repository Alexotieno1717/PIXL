<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function show(Profile $profile)
    {
        // Profile follower/following counts
        $profile->loadCount(['following', 'followers']);

        // Top-level posts for this profile (exclude replies)
        $posts = Post::where('profile_id', $profile->id)
            ->whereNull('parent_id') // top-level posts only
            ->withCount(['likes', 'replies', 'reposts'])
            // If a post is a repost that has its own repost_of relation, eager-load that repost with its counts and profile
            ->with(['repostOf' => function ($q) {
                $q->with('profile')
                    ->withCount(['likes', 'replies', 'reposts']);
            }])
            ->latest()
            ->get();

        return view('profile.show', compact('profile', 'posts'));
    }
}
