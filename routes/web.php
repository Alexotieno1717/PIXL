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
    Route::get('/home', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::scopeBindings()->group(function () {
        Route::post('/{profile:handle}/status/{post}/reply', [PostController::class, 'reply'])
            ->name('posts.reply');

        Route::post('/{profile:handle}/status/{post}/repost', [PostController::class, 'repost'])
            ->name('posts.repost');

        Route::post('/{profile:handle}/status/{post}/quote', [PostController::class, 'quote'])
            ->name('posts.quote');

        Route::post('/{profile:handle}/status/{post}/destroy', [PostController::class, 'destroy'])
            ->name('posts.destroy');

        Route::post('/{profile:handle}/status/{post}/like', [PostController::class, 'like'])
            ->name('posts.like');

        Route::post('/{profile:handle}/status/{post}/unlike', [PostController::class, 'unlike'])
            ->name('posts.unlike');
    });

    Route::post('/{profile:handle}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::post('/{profile:handle}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
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

