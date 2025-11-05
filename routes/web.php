<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('feed/', function () {
    $feedItems = json_decode(json_encode([
        [
            'postedDateTime' => '3h',
            'content' => <<<str
                <p>
                    I made this! <a href="#">#myartwork</a> <a href="#">#pixel</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
                str,
            'likesCount' => 23,
            'replyCount' => 53,
            'repostsCount' => 153,

            'profile' => [
                'avatar' => '/images/michael.png',
                'displayName' => 'Michael',
                'handle' => '@mmich_jj'
            ]
        ]
    ]));
    return view('feed', compact('feedItems'));
});

Route::get('profile/', function () {
    $feedItems = json_decode(json_encode([
        [
            'postedDateTime' => '3h',
            'content' => <<<str
                <p>
                    I made this! <a href="#">#myartwork</a> <a href="#">#pixel</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
                str,
            'likesCount' => 23,
            'replyCount' => 53,
            'repostsCount' => 153,

            'profile' => [
                'avatar' => '/images/michael.png',
                'displayName' => 'Michael',
                'handle' => '@mmich_jj'
            ]
        ]
    ]));
    return view('profile', compact('feedItems'));
});
