<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'price_per_night' => (float) $this->price_per_night,
            'max_guests' => $this->max_guests,
            'owner' => [
                'id' => $this->owner?->id,
                'name' => $this->owner?->name,
                'email' => $this->owner?->email,
            ],
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'amenities' => $this->amenities->map(fn ($amenity) => [
                'id' => $amenity->id,
                'name' => $amenity->name,
            ])->values(),
            'average_rating' => round((float) ($this->reviews->avg('rating') ?? 0), 1),
            'reviews_count' => $this->reviews->count(),
            'created_at' => $this->created_at,
        ];
    }
}
