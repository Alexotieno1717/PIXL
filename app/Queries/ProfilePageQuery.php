<?php

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfilePageQuery
{

    public function __construct(private Profile $subject, private ?Profile $viewer)
    {

    }

    public static function for(Profile $subject, ?Profile $viewer): self
    {
        return new self($subject, $viewer);
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->through(fn($p) => $this->normalize($p));
    }

    public function get(): \Illuminate\Support\Collection
    {
        return $this->baseQuery()->get()->map(fn($p) => $this->normalize($p));
    }

    private function baseQuery()
    {
        $viewerId = $this->viewer?->id ?? 0;

        // Top-level posts for this profile (exclude replies)
        $posts = Post::where('profile_id', $this->subject->id)
            ->whereNull('parent_id') // top-level posts only
            ->withCount(['likes', 'replies', 'reposts'])
            // If a post is a repost that has its own repost_of relation, eager-load that repost with its counts and profile
            ->with([
                'repostOf' => fn($q) => $q
                    ->withCount(['likes', 'replies', 'reposts'])
                    ->with('profile')
                ]
            )
            ->withCount(['likes', 'replies', 'reposts'])
            ->withExists([
                'likes as has_liked' => fn($q) => $q->where('profile_id', $viewerId),
                'reposts as has_reposted' => fn($q) => $q->where('profile_id', $viewerId),
                'repostOf as like_original' => fn($q) =>
                $q->whereHas('likes', fn($q) => $q->where('profile_id', $viewerId)),
                'repostOf as repost_original' => fn($q) =>
                $q->whereHas('reposts', fn($q) => $q->where('profile_id', $viewerId)),
            ])
            ->latest();

        return $posts;
    }

    private function normalize (Post $post): Post
    {
        if ($post->isRepost() && is_null($post->content)){
            $post->repostOf()->has_liked = (bool) $post->like_original;
            $post->repostOf()->has_reposted = (bool) $post->repost_original;
        }

        return $post;
    }
}
