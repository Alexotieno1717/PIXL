<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->with(['repostOf' => fn($q) => $q->withCount(['likes', 'replies', 'reposts'])]
            )
            ->withCount(['likes', 'replies', 'reposts'])
            ->latest()
            ->get();

        return view('profile.show', compact('profile', 'posts'));
    }

    public function replies(Profile $profile)
    {
        // Profile follower/following counts
        $profile->loadCount(['following', 'followers']);

        // Top-level posts for this profile (exclude replies)
        $posts = Post::query()
            ->where(fn($q) => $q
                ->whereBelongsTo($profile, 'profile')
                ->whereNull('parent_id')
            )
            ->orWhereHas('replies', fn($q) => $q
                ->whereBelongsTo($profile, 'profile')
            )->with([
                'profile',
                'repostOf' => fn($q) => $q->withCount(['likes', 'replies', 'reposts']),
                'repostOf.profile',
                'parent.profile',
                'replies' => fn($q) => $q
                ->whereBelongsTo($profile, 'profile')
                ->with('profile')
                ->oldest()
            ])
            ->withCount(['likes', 'replies', 'reposts'])
            ->latest()
            ->get();

        return view('profile.replies', compact('profile', 'posts'));
    }

    public function follow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        $follow = Follow::createFollow($currentProfile, $profile);

        return response()->json(compact('follow'));
    }

    public function unfollow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        $success = Follow::removeFollow($currentProfile, $profile);

        return response()->json(compact('success'));
    }
}
