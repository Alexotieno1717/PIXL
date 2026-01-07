<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $content = $this->content;

        // Decode if JSON
        if (is_string($content)) {
            $decoded = json_decode($content, true);
            $content = $decoded['content'] ?? $content;
        }
        return[
            'id' => $this->id,
            'content' => $content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'repost_of' => new PostResource($this->whenLoaded('repost_of')),
            'replies' => PostResource::collection($this->whenLoaded('replies')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'reposts' => PostResource::collection($this->whenLoaded('reposts')),
        ];
    }
}
