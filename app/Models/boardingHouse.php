<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\Models\facility;
use App\Models\Room;
use App\Models\Category;

class boardingHouse extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function facilities()
    // {
    //     return $this->hasMany(Facility::class, 'boarding_house_id');
    // }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'boarding_house_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
