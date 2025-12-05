<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ExternalItem extends Model
{
    protected $table = 'external_items';

    protected $fillable = [
        'vin',
        'description',
        'car_model_id',
        'year',
        'price',
        'currency',
        'added_by',
        'source_info',
        'location',
        'condition',
        'mileage',
        'color'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
    ];

    /**
     * Get the vendor who sourced this item.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    /**
     * Get all shipment items for this external item (polymorphic).
     */
    public function shipmentItems(): MorphMany
    {
        return $this->morphMany(ShipmentItem::class, 'item');
    }

    /**
     * Get all shipments containing this external item (through shipment_items).
     */
    public function shipments()
    {
        return $this->hasManyThrough(
            Shipment::class,
            ShipmentItem::class,
            'item_id',
            'id',
            'id',
            'shipment_id'
        )->where('shipment_items.item_type', 'App\Models\ExternalItem');
    }

    /**
     * Get all payment transactions for this external item's shipping.
     */
    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class, 'related_id')
            ->where('related_type', 'App\Models\ExternalItem')
            ->where('transaction_type', 'Shipping');
    }
}
