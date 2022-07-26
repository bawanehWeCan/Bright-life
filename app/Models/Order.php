<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function products(){
        return $this->hasMany(CartItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->where('type','user');
    }

    public function supplier(){
        return $this->belongsTo(User::class, 'supplier_id')->where('type','supplier');
    }

    protected static function booted()
    {
        static::creating(function(Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        // SELECT MAX(number) FROM orders
        $year =  \Carbon\Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }

    public function codes(){
        return $this->belongsToMany(PromoCode::class);
    }

    public function review(){
        return $this->morphOne(Review::class,'reviewable');
    }


}
