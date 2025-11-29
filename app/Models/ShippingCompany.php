<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    //
    protected $fillable = [
        'name',
        'short_name',
        'contact_number',
        'email',
        'address',
        'website',
    ];
}
