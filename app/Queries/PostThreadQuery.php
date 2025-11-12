<?php

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Pagination\LengthAwarePaginator;

class PostThreadQuery
{


    public function __construct(private Post $post, private ?Profile $viewer)
    {
        $this->post = $post;
        $this->viewer = $viewer;
    }

    public static function for(Post $post, ?Profile $viewer): self
    {
        return new self($post, $viewer);
    }

    public function load() : Post
    {
        $viewerId = $this->viewer ? $this->viewer->id : 0;

        $this->post->load([
            'profile',
            'repostOf.profile',
            'replies' => function ($q) use ($viewerId) {
                $q->withCount(['likes', 'replies', 'reposts'])
                    ->withExists([
                        'likes as has_liked' => fn($q) => $q->where('profile_id', $viewerId),
                        'likes as has_reposted' => fn($q) => $q->where('profile_id', $viewerId),
                    ])
                    ->with([
                        'profile',
                        'parent' => function ($q) {
                            $q->with('profile');
                        },
                        'replies' => function ($q) use ($viewerId) {
                            $q->withCount(['likes', 'replies', 'reposts'])
                                ->withExists([
                                    'likes as has_liked' => fn($q) => $q->where('profile_id', $viewerId),
                                    'likes as has_reposted' => fn($q) => $q->where('profile_id', $viewerId),
                                ])
                                ->with('profile');
                        },
                    ])
                    ->oldest();
            }
        ])->loadCount(['likes', 'replies', 'reposts'])
            ->loadExists([
                'likes as has_liked' => fn($q) => $q->where('profile_id', $viewerId),
                'likes as has_reposted' => fn($q) => $q->where('profile_id', $viewerId),
            ]);

        return $this->post;
    }
}
