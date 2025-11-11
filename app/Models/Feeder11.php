<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder11 extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'feeder33_id',
    ];

    public function feeder11()
    {
        return $this->hasMany(Transformer::class);
    }

    public function feeder33()
    {
        return $this->belongsTo(Feeder33::class, 'feeder33_id');
    }
}
