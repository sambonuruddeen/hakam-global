<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarListing extends Model
{
    protected $table = 'car_listings';

    protected $fillable = [
        'car_model_id',
        'vin',
        'make',
        'model',
        'year',
        'value',
        'currency',
        'color',
        'mileage',
        'engine_type',
        'fuel_type',
        'transmission',
        'body_style',
        'drive_train',
        'condition',
        'location',
        'options',
        'price',
        'status',
        'additional_notes',
        'added_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'mileage' => 'integer',
    ];

    /**
     * Get the car model for this listing.
     */
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the vendor who provided this listing.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the user who added this listing.
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get the car order for this listing (one-to-one).
     */
    public function carOrder(): HasOne
    {
        return $this->hasOne(CarOrders::class);
    }
}
