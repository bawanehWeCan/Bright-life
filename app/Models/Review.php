<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function user(){
        return $this->belongsTo(User::class)->where('type','user');
    }

    public function supplier(){
        return $this->belongsTo(User::class,'supplier_id')->where('type','user');;
    }

}

