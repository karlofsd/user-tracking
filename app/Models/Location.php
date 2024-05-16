<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'address',
        'locality',
        'city',
        'user_id'
    ];

    protected function user()
    {
        return $this->belongsTo(User::class);
    }
}
