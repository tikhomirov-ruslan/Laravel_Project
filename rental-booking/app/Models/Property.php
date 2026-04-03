<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'user_id',
            'category_id',
            'title',
            'description',
            'address',
            'price_per_night',
            'max_guests'
        ];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function amenities() {
        return $this->belongsToMany(Amenity::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
