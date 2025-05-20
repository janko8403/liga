<?php

namespace App\Http\Resources;

use App\Models\AdminPermissionDict;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'name'     => $this->name,
            'lastname'    => $this->lastname,
            'email'    => $this->email,
            'permissions' => AdminPermissionDict::where('id',$this->permissions)->first()
        ];
    }
}
