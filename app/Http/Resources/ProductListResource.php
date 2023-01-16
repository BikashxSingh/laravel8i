<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'id' => (string)$this->id,
            'type' => 'product',
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                'short_description' => $this->short_description,
                'pImage' => $this->pImage ? asset(Storage::url($this->pImage)) : null,
                'status' => $this->status,
                'price' => $this->price,
            ],
            'total_reviews' => $this->total_reviews,
            'avg_rating' => $this->avg_rating
        ];
    }
}
