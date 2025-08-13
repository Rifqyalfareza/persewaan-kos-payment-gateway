<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class room extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function roomImage()
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }
    public function facilities(): HasMany
    {
        return $this->hasMany(Facility::class, 'rooms_id');
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'rooms_id');
    }
}
