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
            'origin' => $this->origin,
            'destination' => $this->destination,
            'shipment_date' => $this->shipment_date,
            'delivery_date' => $this->delivery_date,
            'status' => $this->status,
            // New polymorphic shipment items (supports both platform and external cars)
            'shipment_items' => ShipmentItemResource::collection($this->whenLoaded('shipmentItems')),
            // Items separated by type for convenience
            'car_orders' => CarOrdersResource::collection($this->whenLoaded('carOrders')),
            'external_items' => ExternalItemResource::collection($this->whenLoaded('externalItems')),
            // Payment transactions for shipping costs
            'payment_transactions' => PaymentTransactionResource::collection($this->whenLoaded('paymentTransactions')),
            // Legacy support for old car_shipments table
            'car_shipments' => \App\Http\Resources\CarShipmentResource::collection($this->whenLoaded('carShipments')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
