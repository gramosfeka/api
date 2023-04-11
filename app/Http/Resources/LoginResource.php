<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'status'        => $this->status,
            'message'       => $this->message,
            'user'          => new UserResource($this->user) ?? null,
            'authorisation' => $this->authorisation ?? null,

        ];


    }
}
