<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $fillable = [
        'region',
        'street',
        'building_number',
        'floor_number',
        'apartment_number',
        'additional_tips',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
