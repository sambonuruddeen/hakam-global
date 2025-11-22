<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //
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
        // Item fields
        'item_description',
        'vin',
        'item_value',
        'currency',
    ];
}
