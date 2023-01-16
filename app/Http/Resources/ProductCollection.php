<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductListResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = ProductListResource::class;

    public function toArray($request)
    {
        // dd($this->collection);
        return ([
            'data' => $this->collection,
            'meta' => [
                'meta-data' => 'meta-value'
            ],
        ]);
    }
}
