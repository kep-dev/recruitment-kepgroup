<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestCharacteristic extends Model
{
    use HasUuids;

    protected $fillable = [
        'psychotest_aspect_id',
        'code',
        'name',
        'description',
        'order',
    ];

    public function psychotestAspect()
    {
        return $this->belongsTo(PsychotestAspect::class);
    }

    public function psychotestCharacteristicScores()
    {
        return $this->hasMany(PsychotestCharacteristicScore::class, 'characteristic_id');
    }

}
