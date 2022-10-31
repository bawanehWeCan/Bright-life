<?php

namespace App\Http\Resources;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return[

            'id'=>$this->id,
            'title'=>$this->title,
            'content'=>$this->content,
            'points'=>$this->points,
            'user'=>new UserResource( User::findOrFail($this->user_id) ),
            'supplier_id'=>new UserResource( User::findOrFail($this->supplier_id) ),
            'status'=>$this->status,


        ];



    }
}
