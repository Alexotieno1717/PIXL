<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dev/login', function () {
    $user = User::inRandomOrder()->first();
    Auth::login($user);
    request()->session()->regenerate();
    return redirect()->intended(route('profile.show', $user->profile));
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('post.index');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
});

Route::get('/dev/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->intended('/feed');
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
            ],

            'replies' => [
               [
                   'postedDateTime' => '3h',
                   'likesCount' => 52,
                   'replyCount' => 45,
                   'repostsCount' => 102,
                   'content' => <<<str
                    <p>Heh — this looks just like me!</p>
                    str,
                   'profile' => [
                       'avatar' => '/images/simon-chilling.png',
                       'displayName' => 'Simon',
                       'handle' => '@simonswiss'
                   ],
               ]
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
            ],
            'replies' => [
                [
                    'postedDateTime' => '3h',
                    'likesCount' => 52,
                    'replyCount' => 45,
                    'repostsCount' => 102,
                    'content' => <<<str
                    <p>Heh — this looks just like me!</p>
                    str,
                    'profile' => [
                        'avatar' => '/images/simon-chilling.png',
                        'displayName' => 'Simon',
                        'handle' => '@simonswiss'
                    ],
                ]
            ]
        ]
    ]));
    return view('profile', compact('feedItems'));
});
Route::get('/{profile:handle}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/{profile:handle}/with_replies', [ProfileController::class, 'replies'])->name('profile.replies');

Route::scopeBindings()->group(function () {
    Route::get('/{profile:handle}/status/{post}', [PostController::class, 'show'])
        ->name('post.show');
});

