<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['displayname'] = $this->displayname;
        $data['email'] = $this->email;
        $data['avatar'] = $this->avatar;
        return $data;
        // return parent::toArray($request);
    }
}
