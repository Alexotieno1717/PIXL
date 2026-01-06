<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('allows a profile to publish a post', function (): void {
    $profile = Profile::factory()->create();
    $post = Post::publish($profile, 'Content of a Post');

    expect($post->exists)->toBeTrue()
        ->and($post->profile->is($profile))->toBeTrue()
        ->and($post->parent_id)->toBeNull()
        ->and($post->repost_of_id)->toBeNull();
});

test('can reply to a post', function (): void {
    $original = Post::factory()->create();

    $replier = Profile::factory()->create();

    $reply = Post::reply($replier, $original, 'Reply to a Post');

    expect($reply->parent->is($original))->toBeTrue()
        ->and($original->replies()->count())->toBe(1);

});

test('can have many replies', function (): void {
    $original = Post::factory()->create();
    $replies = Post::factory()->count(4)->reply($original)->create();

    expect($replies->first()->parent->is($original))->toBeTrue()
        ->and($original->replies)->toHaveCount(4)
        ->and($original->replies->contains($replies->first()))->toBeTrue();

});

test('create plain repost', function (): void {
    $original = Post::factory()->create();

    $repostProfile = Profile::factory()->create();
    $repost = Post::repost($repostProfile, $original);

    expect($repost->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(1)
        ->and($repost->content)->toBeNull();

});

test('can have many reposts', function (): void {
    $original = Post::factory()->create();
    $reposts = Post::factory()->count(4)->repost($original)->create();

    expect($reposts->first()->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(4)
        ->and($original->reposts->contains($reposts->first()))->toBeTrue();

});

test('create quote repost', function (): void {
    $content = 'Quote repost';
    $original = Post::factory()->create();

    $repostProfile = Profile::factory()->create();
    $repost = Post::repost($repostProfile, $original, $content);

    expect($repost->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(1)
        ->and($repost->content)->toBe($content);

});

test('prevent duplicate reposts', function (): void {
    $post = Post::factory()->create();
    $profile = Profile::factory()->create();

    $r1 = Post::repost($profile, $post);
    $r2 = Post::repost($profile, $post);

    expect($r1->id)->toBe($r2->id);
});

test('remove a repost', function (): void {
    $original = Post::factory()->create();
    $profile = Post::factory()->repost($original)->create()->profile;

    $success = Post::removeRepost($profile, $original);

    expect($original->reposts)->toHaveCount(0)
        ->and($success)->toBeTrue();
});
