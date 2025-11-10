<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class AuthenticationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id'    => $this->id,
                'name'  => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'role'  => $this->getRoleNames()->first(), // TODO: list all roles if multiple
                'profile_image' => $this->profile_image,
        ];
    }
}
