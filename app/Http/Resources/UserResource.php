<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function role($id){
        $role = Role::findOrFail($id);
        return [
            "name" => $role->name
        ];
    }
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "phone_number" => $this->phone_number,
            "birthday" => $this->birthday,
            "email" => $this->email,
            "role" => $this->role($this->role_id),
        ];
    }
}
