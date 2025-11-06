<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('allows a profile to publish a post', function () {
    $profile = Profile::factory()->create();
    $post = Post::publish($profile, 'Content of a Post');

    expect($post->exists)->toBeTrue()
        ->and($post->profile->is($profile))->toBeTrue()
        ->and($post->parent_id)->toBeNull()
        ->and($post->repost_of_id)->toBeNull();
});

test('can reply to a post', function () {
    $original = Post::factory()->create();

    $replier = Profile::factory()->create();

    $reply = Post::reply($replier, $original, 'Reply to a Post');

    expect($reply->parent->is($original))->toBeTrue()
        ->and($original->replies()->count())->toBe(1);

});

test('can have may replies', function () {
    $original = Post::factory()->create();
    $replies = Post::factory()->count(4)->reply($original)->create();


    expect($replies->first()->parent->is($original))->toBeTrue()
        ->and($original->replies)->toHaveCount(4)
        ->and($original->replies->contains($replies->first()))->toBeTrue();

});
