<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Queries\ProfilePageQuery;
use App\Queries\ProfileWithRepliesQuery;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function show(Profile $profile)
    {
        // Profile follower/following counts
        $profile->loadCount(['following', 'followers']);

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

        return view('profile.show', compact('profile', 'posts'));
    }

    public function replies(Profile $profile)
    {
        // Profile follower/following counts
        $profile->loadCount(['following', 'followers']);

        $posts = ProfileWithRepliesQuery::for($profile, Auth::user()?->profile)->get();

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
