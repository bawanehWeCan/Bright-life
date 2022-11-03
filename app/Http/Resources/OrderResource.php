<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\AddressItemResource;
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
            'type'=>$this->type,
            'lat'=>$this->lat,
            'long'=>$this->long,
            'total'=>number_format($this->total,2),
            'tax'=>number_format($this->tax,2),
            'delivery_fee'=>number_format($this->delivery_fee,2),
            'discount'=>number_format($this->discount,2),
            'percentage'=>number_format($this->percentage,2),
            'number'=>$this->number,
            'order_value'=>number_format($this->order_value,2),
            'user'=>new UserResource( User::findOrFail($this->user_id) ),
            'address'=>new AddressItemResource( $this->user->address->first() ),
            'supplier'=>new UserResource( User::findOrFail($this->supplier_id) ),
            'products'=> CartItemResource::collection($this->products),
        ];
    }
}
