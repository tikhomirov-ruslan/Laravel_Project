<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string', 'max:500'],
            'price_per_night' => ['sometimes', 'numeric', 'min:0'],
            'max_guests' => ['sometimes', 'integer', 'min:1'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'amenities' => ['sometimes', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
        ];
    }
}
