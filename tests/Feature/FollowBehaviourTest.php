<?php

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile cannot follow it self', function (): void {
    $profile = Profile::factory()->create();

    expect(fn () => Follow::createFollow($profile, $profile))
        ->toThrow(\InvalidArgumentException::class, 'profile cannot follow it self');

});

test('profile can follow another profile', function (): void {
    $profile1 = Profile::factory()->create();
    $profile2 = Profile::factory()->create();

    $follow = Follow::createFollow($profile1, $profile2);

    expect($profile1->following->contains($profile2))->toBeTrue()
        ->and($profile2->followers->contains($profile1))->toBeTrue()
        ->and($follow->follower->id)->toBe($profile1->id)
        ->and($follow->following->id)->toBe($profile2->id);
});

test('profile can unfollow another profile', function (): void {
    $profile1 = Profile::factory()->create();
    $profile2 = Profile::factory()->create();

    $follow = Follow::createFollow($profile1, $profile2);
    $success = Follow::removeFollow($profile1, $profile2);

    expect($profile1->following->contains($profile2))->toBeFalse()
        ->and($profile2->followers->contains($profile1))->toBeFalse()
        ->and($success)->toBeTrue()
        ->and($follow->fresh())->toBeNull();
});
