<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarShipments extends Model
{
    protected $table = 'car_shipments';

    protected $fillable = [
        'car_order_id',
        'shipment_id',
    ];

    /**
     * Get the car order for this shipment record.
     */
    public function carOrder(): BelongsTo
    {
        return $this->belongsTo(CarOrders::class);
    }

    /**
     * Get the shipment for this car order.
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
