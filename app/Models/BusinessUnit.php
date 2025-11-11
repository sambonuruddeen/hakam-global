<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
    ];

    public function businessUnit()
    {
        return $this->hasMany(Feeder33::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
