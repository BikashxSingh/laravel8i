<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ([
            'from' => new UserResource(User::find($this->from)),
            'to' => new UserResource(User::find($this->to)),
            'is_read' => $this->is_read,
            'message' => $this->message,
        ]);
    }
}
