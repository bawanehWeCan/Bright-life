<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'status'=>$this->status,
            'payment_method'=>$this->payment_method,
            'note'=>$this->note,
            'lat'=>$this->lat,
            'long'=>$this->long,
            'total'=>$this->total,
            'tax'=>$this->tax,
            'delivery_fee'=>$this->delivery_fee,
            'discount'=>$this->discount,
            'percentage'=>$this->percentage,
            'number'=>$this->number,
            'order_value'=>$this->order_value,
            'user'=>new UserResource( User::findOrFail($this->user_id) ),
            'supplier_id'=>new UserResource( User::findOrFail($this->supplier_id) ),
            'products'=> CartItemResource::collection($this->products),
        ];
    }
}
