<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car_model_id' => $this->car_model_id,
            'car_model' => new CarModelResource($this->whenLoaded('carModel')),
            'vendor_id' => $this->vendor_id,
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'vin' => $this->vin,
            'color' => $this->color,
            'mileage' => $this->mileage,
            'condition' => $this->condition,
            'year' => $this->year,
            'price' => (float)$this->price,
            'currency' => $this->currency,
            'status' => $this->status,
            'location' => $this->location,
            'additional_notes' => $this->additional_notes,
            'added_by' => $this->added_by,
            'added_by_user' => new UserResource($this->whenLoaded('addedBy')),
            'car_order' => new CarOrdersResource($this->whenLoaded('carOrder')),
            'is_sold' => $this->carOrder ? true : false,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
