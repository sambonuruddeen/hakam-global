<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vin' => $this->vin,
            'description' => $this->description,
            'car_model' => new CarModelResource($this->whenLoaded('carModel')),
            'year' => $this->year,
            'price' => (float)$this->price,
            'currency' => $this->currency,
            'condition' => $this->condition,
            'mileage' => $this->mileage,
            'color' => $this->color,
            'location' => $this->location,
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'source_info' => $this->source_info,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
