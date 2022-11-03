<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionItemResource extends JsonResource
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
            'type'=>$this->type,
            'status'=>$this->status,
            'amount'=>number_format($this->amount,2),
            'wallet_id'=>$this->wallet_id,
            'wallet_name'=>$this->wallet->name,
            'wallet_total'=>number_format($this->wallet->total,2),
            'user'=>new UserResource(User::findOrFail($this->user_id)),
        ];
    }
}
