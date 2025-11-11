<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transformer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'feeder11_id'
    ];

    public function feeder11()
    {
        return $this->belongsTo(Feeder11::class, 'feeder11_id');
    }

    public function customer()
    {
        return $this->hasMany(CustomerValidation::class);
    }
}
