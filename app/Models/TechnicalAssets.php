<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalAssets extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
    ];

    // link with Technical Assets Conditions Table    public function conditions()
    public function conditions()
    {
        return $this->hasMany(TechnicalAssetsCondtiton::class, 'asset_id');
    }

}
