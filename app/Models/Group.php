<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $fillable = ['name','type','product_id'];


    public function items(){
        return $this->hasMany(GroupItem::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}