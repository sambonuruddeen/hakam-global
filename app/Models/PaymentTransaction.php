<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';

    protected $fillable = [
        'transaction_type',
        'related_id',
        'related_type',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'payment_date',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'payment_status' => 'string',
        'transaction_type' => 'string',
    ];

    /**
     * Get the related model (CarOrder or Shipment).
     */
    public function related()
    {
        return $this->morphTo('related');
    }

    /**
     * Get the car order if this is a car purchase payment.
     */
    public function carOrder()
    {
        if ($this->related_type === 'App\Models\CarOrder') {
            return $this->belongsTo(CarOrders::class, 'related_id');
        }
        return null;
    }

    /**
     * Get the shipment if this is a shipping payment.
     */
    public function shipment()
    {
        if ($this->related_type === 'App\Models\Shipment') {
            return $this->belongsTo(Shipment::class, 'related_id');
        }
        return null;
    }

    /**
     * Scope: Get only car purchase payments.
     */
    public function scopeCarPurchases($query)
    {
        return $query->where('transaction_type', 'Car Purchase');
    }

    /**
     * Scope: Get only shipping payments.
     */
    public function scopeShippingPayments($query)
    {
        return $query->where('transaction_type', 'Shipping');
    }

    /**
     * Scope: Get only completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'Completed');
    }

    /**
     * Scope: Get only pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'Pending');
    }
}
