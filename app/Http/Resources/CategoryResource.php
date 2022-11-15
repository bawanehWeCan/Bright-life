<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'=>$this->name,
            'image'=>$this->image,
            'type'=>$this->type,
            'best'=>SupplierResource::collection(User::where('type', 'supplier')->orderBy('points','desc')->get()),
            'suppliers'=>SupplierResource::collection($this->suppliers),
        ];
    }
}
