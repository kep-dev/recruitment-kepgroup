<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestCharacteristicScore extends Model
{
    use HasUuids;

    protected $fillable = [
        'characteristic_id',
        'score',
        'description',
    ];

    public function characteristic()
    {
        return $this->belongsTo(PsychotestCharacteristic::class, 'characteristic_id');
    }

}
