<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'vendor_type',
        'contact_person',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'payment_terms',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
        'vendor_type' => 'string',
    ];

    /**
     * Get all car listings from this vendor.
     */
    public function carListings(): HasMany
    {
        return $this->hasMany(CarListing::class);
    }

    /**
     * Get all external items from this vendor.
     */
    public function externalItems(): HasMany
    {
        return $this->hasMany(ExternalItem::class);
    }
}
