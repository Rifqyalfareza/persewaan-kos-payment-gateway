<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
}
