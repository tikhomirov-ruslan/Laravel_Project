<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $property = $this->route('property');
        return $user && $user->is_active && ($user->role === 'admin' || $user->id === $property->owner_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'bedrooms' => 'integer|min:1',
            'bathrooms' => 'integer|min:1',
            'max_guests' => 'integer|min:1',
            'is_available' => 'boolean',
        ];
    }
}
