<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Make extends Model
{
    protected $table = 'makes';

    protected $fillable = [
        'name',
        'country',
        'website',
    ];

    /**
     * Get all car models from this make.
     */
    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
}
