<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShipmentItem extends Model
{
    protected $table = 'shipment_items';

    protected $fillable = [
        'shipment_id',
        'item_type',
        'item_id',
        'custom_description',
        'custom_price',
        'custom_currency',
    ];

    protected $casts = [
        'custom_price' => 'decimal:2',
    ];

    /**
     * Get the shipment this item belongs to.
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    /**
     * Get the polymorphic item model (CarOrder or ExternalItem).
     */
    public function item()
    {
        return $this->morphTo();
    }

    /**
     * Get the actual price for this item (custom or from item).
     */
    public function getActualPrice()
    {
        if ($this->custom_price) {
            return $this->custom_price;
        }

        if ($this->item_type === 'App\Models\CarOrder') {
            return $this->item?->purchase_price;
        }

        return $this->item?->price;
    }

    /**
     * Get the actual currency for this item.
     */
    public function getActualCurrency()
    {
        if ($this->custom_currency) {
            return $this->custom_currency;
        }

        if ($this->item_type === 'App\Models\CarOrder') {
            return $this->item?->purchase_currency;
        }

        return $this->item?->currency;
    }
}
