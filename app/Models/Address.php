<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    public $fillable = [
        'city',
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
