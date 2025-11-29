<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarOrdersResource extends JsonResource
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
            'user_id' => $this->user_id,
            'car_listing_id' => $this->car_listing_id,
            'purchase_price' => (float)$this->purchase_price,
            'purchase_currency' => $this->purchase_currency,
            'order_status' => $this->order_status,
            'purchase_date' => $this->purchase_date,
            'shipment_id' => $this->shipment_id,
            // Car listing with full hierarchy
            'car_listing' => new CarListingResource($this->whenLoaded('carListing')),
            'user' => new UserResource($this->whenLoaded('user')),
            'shipment' => new ShipmentResource($this->whenLoaded('shipment')),
            'shipment_item' => new ShipmentItemResource($this->whenLoaded('shipmentItem')),
            'payment_transactions' => PaymentTransactionResource::collection($this->whenLoaded('paymentTransactions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
