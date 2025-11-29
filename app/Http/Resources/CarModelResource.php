<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'make_id' => $this->make_id,
            'make' => new MakeResource($this->whenLoaded('make')),
            'name' => $this->name,
            'year' => $this->year,
            'engine_type' => $this->engine_type,
            'fuel_type' => $this->fuel_type,
            'transmission' => $this->transmission,
            'body_style' => $this->body_style,
            'drive_train' => $this->drive_train,
            'car_listings' => CarListingResource::collection($this->whenLoaded('carListings')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
