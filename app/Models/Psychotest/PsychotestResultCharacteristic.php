<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestResultCharacteristic extends Model
{
    use HasUuids;

    protected $fillable = [
        'attempt_id',
        'characteristic_id',
        'raw_score',
        'scaled_score',
    ];

    public function attempt()
    {
        return $this->belongsTo(PsychotestAttempt::class);
    }

    public function characteristic()
    {
        return $this->belongsTo(PsychotestCharacteristic::class);
    }
}
