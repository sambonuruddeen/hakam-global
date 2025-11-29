<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shipment_id' => $this->shipment_id,
            'item_type' => $this->item_type,
            'item_id' => $this->item_id,
            'item' => $this->resolveitem(),
            'custom_description' => $this->custom_description,
            'custom_price' => $this->custom_price ? (float)$this->custom_price : null,
            'custom_currency' => $this->custom_currency,
            'actual_price' => (float)$this->getActualPrice(),
            'actual_currency' => $this->getActualCurrency(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Resolve the polymorphic item relationship to its resource.
     */
    private function resolveitem()
    {
        if ($this->item_type === 'App\Models\CarOrder') {
            return new CarOrdersResource($this->whenLoaded('item'));
        }

        if ($this->item_type === 'App\Models\ExternalItem') {
            return new ExternalItemResource($this->whenLoaded('item'));
        }

        return null;
    }
}
