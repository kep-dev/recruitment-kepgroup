<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestResultAspect extends Model
{
    use HasUuids;

    protected $fillable = [
        'attempt_id',
        'aspect_id',
        'raw_score',
        'scaled_score',
    ];

    public function attempt()
    {
        return $this->belongsTo(PsychotestAttempt::class);
    }

    public function aspect()
    {
        return $this->belongsTo(PsychotestAspect::class);
    }
}
