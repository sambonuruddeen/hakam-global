<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder33 extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business_unit_id'
    ];

    public function feeder33()
    {
        return $this->hasMany(Feeder11::class);
    }

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class, 'business_unit_id');
    }
}
