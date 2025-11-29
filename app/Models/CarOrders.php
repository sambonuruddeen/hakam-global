<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarOrders extends Model
{
    protected $table = 'car_orders';

    protected $fillable = [
        'user_id',
        'car_listing_id',
        'purchase_price',
        'purchase_currency',
        'order_status',
        'purchase_date',
        'shipment_id',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    /**
     * Get the user who placed this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car listing for this order.
     */
    public function carListing(): BelongsTo
    {
        return $this->belongsTo(CarListing::class);
    }

    /**
     * Get the shipment this order is directly associated with (optional).
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    /**
     * Get the shipment item(s) linking this order to shipment(s).
     */
    public function shipmentItem(): MorphOne
    {
        return $this->morphOne(ShipmentItem::class, 'item');
    }

    /**
     * Get all payment transactions for this order (car purchase + shipping).
     */
    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class, 'related_id')
            ->where('related_type', 'App\Models\CarOrder');
    }

    /**
     * Get car purchase payment transactions only.
     */
    public function purchasePayments(): HasMany
    {
        return $this->paymentTransactions()
            ->where('transaction_type', 'Car Purchase');
    }
}
