<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'total_price' => (float) $this->total_price,
            'status' => $this->status,
            'guest' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
            'property' => $this->property ? [
                'id' => $this->property->id,
                'title' => $this->property->title,
                'address' => $this->property->address,
                'price_per_night' => (float) $this->property->price_per_night,
            ] : null,
            'review_id' => $this->review?->id,
            'created_at' => $this->created_at,
        ];
    }
}
