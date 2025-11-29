<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shipment extends Model
{
    protected $fillable = [
        'shipping_company',
        'container_type',
        'container_number',
        'tracking_number',
        'origin',
        'destination',
        'shipment_date',
        'delivery_date',
        'status',
    ];

    protected $casts = [
        'shipment_date' => 'date',
        'delivery_date' => 'date',
    ];

    /**
     * Get all shipment items (both platform and external cars).
     */
    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    /**
     * Get all car orders in this shipment (through shipment_items).
     */
    public function carOrders()
    {
        return $this->hasManyThrough(
            CarOrders::class,
            ShipmentItem::class,
            'shipment_id',
            'id',
            'id',
            'item_id'
        )->where('shipment_items.item_type', 'App\Models\CarOrders');
    }

    /**
     * Get all external items in this shipment (through shipment_items).
     */
    public function externalItems()
    {
        return $this->hasManyThrough(
            ExternalItem::class,
            ShipmentItem::class,
            'shipment_id',
            'id',
            'id',
            'item_id'
        )->where('shipment_items.item_type', 'App\Models\ExternalItem');
    }

    /**
     * Get all car shipment records for this shipment (legacy support).
     */
    public function carShipments(): HasMany
    {
        return $this->hasMany(CarShipments::class);
    }

    /**
     * Get all payment transactions for this shipment (shipping costs).
     */
    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class, 'related_id')
            ->where('related_type', 'App\Models\Shipment');
    }
}
