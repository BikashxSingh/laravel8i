<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
    //    dd(MessageResource::collection($this->whenLoaded('messages')));
        return ([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'categories' => CategoryResource::collection($this->whenLoaded('category')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'messages' => MessageResource::collection($this->whenLoaded('messages'))
        ]);
    }
}
