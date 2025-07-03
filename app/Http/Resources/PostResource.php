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
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'short_description' => $this->short_description,
            'image' => $this->image,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'categories' => $this->categories->pluck('name'),
            'user' => $this->user->name ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
