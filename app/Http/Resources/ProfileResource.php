<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'handle' => $this->handle,
            'avatar_url' => $this->avatar_url,
            // Include counts only when they were actually loaded
            'followers_count' => $this->whenCounted('followers'),
            'followings_count' => $this->whenCounted('followings'),
        ];
    }
}
