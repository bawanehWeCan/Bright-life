<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory,HasTranslations;

    public $fillable = ['question','answer'];
    public $translatable = ['question','answer'];

    public $timestamps = true;
}
