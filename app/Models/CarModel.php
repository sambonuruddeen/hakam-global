<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    protected $table = 'car_models';

    protected $fillable = [
        'make_id',
        'name',
        'year',
        'engine_type',
        'fuel_type',
        'transmission',
        'body_style',
        'drive_train',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    /**
     * Get the make this model belongs to.
     */
    public function make(): BelongsTo
    {
        return $this->belongsTo(Make::class);
    }

    /**
     * Get all car listings for this model.
     */
    public function carListings(): HasMany
    {
        return $this->hasMany(CarListing::class);
    }
}
