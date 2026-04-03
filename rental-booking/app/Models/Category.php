<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
