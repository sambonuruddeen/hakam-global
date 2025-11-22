<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shipping_company' => $this->shipping_company,
            'container_type' => $this->container_type,
            'container_number' => $this->container_number,
            'tracking_number' => $this->tracking_number,
            'item_description' => $this->item_description,
            'vin' => $this->vin,
            'item_value' => $this->item_value,
            'currency' => $this->currency,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'shipment_date' => $this->shipment_date,
            'delivery_date' => $this->delivery_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
