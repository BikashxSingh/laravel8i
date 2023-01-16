<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected $pagination;

    public function __construct($resource)
    {
        // $this->pagination = [
        //     'total' => $resource->total(),
        //     'count' => $resource->count(),
        //     'per_page' => $resource->perPage(),
        //     'current_page' => $resource->currentPage(),
        //     'total_pages' => $resource->lastPage()
        // ];
        //     $resource = $resource->getCollection();
        //     // dd($this->pagination);

        // parent::__construct($resource);
    }

    public function toArray($request)
    {
        // dd($this->pagination);


        return ([
            'data' => $this->collection,
            // "links"=> [
            //     "first" => "http://127.0.0.1:8000/pagination?page=1",
            //     "last" => "http://127.0.0.1:8000/pagination?page=1",
            //     "prev" => null,
            //     "next" => null
            // ],
            // "meta" =>[
            //     "current_page" => 1,
            //     "from" => 1,
            //     "last_page" => 1,
            //     "path" => "http://127.0.0.1:8000/pagination",
            //     "per_page" => 15,
            //     "to" => 10,
            //     "total" => 10
            // ]

            // 'pagination' => $this->pagination
        ]);
    }
}
