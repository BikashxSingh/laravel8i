<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\Cloner\Data;
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
        
        // dd($this->childCategories->toArray());
        return ([
            'id' => (string)$this->id,
            'type' => 'category',
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                // 'myfile' => $this->file(),
                'myfile' => $this->myfile ? asset(Storage::url($this->myfile)) : null,

                // 'myfile' => $this->file(),   
                'status' => $this->status,
                'parent_id' => (string)$this->parent_id,
                'parent' => new self($this->whenLoaded('parentCategory')),
                'child' => self::collection($this->whenLoaded('childCategories')),

                'created_at' => (string)$this->created_at,
                'updated_at' => (string)$this->updated_at,
            ],
            // 'parent' => new self($this->whenLoaded('parentCategory')),
            // 'parent' => new self($this->parentCategory),
            // 'child' => self::collection($this->when($request->parent, $this->childCategories)),
            // 'child' => self::collection($this->childCategories),
            // 'child' => self::collection($this->whenLoaded('childCategories')),

        ]);

    }
}
