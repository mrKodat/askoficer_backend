<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
        $data['secondUserId'] = $this->secondUserId;
        $data['user'] = $this->authId == $this->userId ? new UserResource(User::find($this->secondUserId)) : new UserResource(User::find($this->userId));
        $data['created_at'] = $this->created_at;
        $data['messages'] = MessageResource::collection($this->messages);
        return $data;
        // return parent::toArray($request);
    }
}
