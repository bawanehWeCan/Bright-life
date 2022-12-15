<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'avg_points'     => (float)number_format($this->points, 2, '.', ''),
            // 'reviews'     => $this->ratings,
            'image'     => (string)$this->image,
            'cover'     => (string)$this->cover,
            'location'     => (string)$this->location,
            'type'=>'A',
            'description'     => (string)$this->description,
            'categories'     => CatResource::collection($this->categories),
            'products'     => ProductResource::collection($this->products),
        ];
    }
}
