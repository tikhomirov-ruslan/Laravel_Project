<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'price_per_night' => $this->price_per_night,
            'max_guests' => $this->max_guests,
            'owner' => $this->owner->name,
            'amenities' => $this->amenities->pluck('name'),
            'average_rating' => $this->reviews()->avg('rating') ?? 0,
            'created_at' => $this->created_at,
        ];

//        return parent::toArray($request);
    }
}
