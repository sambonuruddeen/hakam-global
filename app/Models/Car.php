<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
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
        'status',
        'additional_notes',

    ];

    /**
     * Get all car orders for this car model.
     */
    public function carOrders(): HasMany
    {
        return $this->hasMany(CarOrders::class);
    }
}
