<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupItem extends Model
{
    use HasFactory;

    public $fillable = ['name','price','group_id'];
}
