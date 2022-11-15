<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'best'=>SupplierResource::collection(User::with([ 'review'])
            ->leftJoin('reviews', 'reviews.supplier_id', '=', 'users.id')
            ->select(['products.*',
                DB::raw('AVG(reviews.points) as ratings_average')
                ])
            ->orderBy('ratings_average', 'desc')
            ->get()),
            'suppliers'=>SupplierResource::collection($this->suppliers),
        ];
    }
}


