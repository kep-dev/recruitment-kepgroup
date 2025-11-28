<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestOptionCharacteristicMapping extends Model
{
    use HasUuids;

    protected $fillable = [
        'option_id',
        'aspect_id',
        'characteristic_id',
        'weight',
    ];

    public function option()
    {
        return $this->belongsTo(PsychotestQuestionOption::class, 'option_id');
    }

    public function aspect()
    {
        return $this->belongsTo(PsychotestAspect::class, 'aspect_id');
    }

    public function characteristic()
    {
        return $this->belongsTo(PsychotestCharacteristic::class, 'characteristic_id');
    }


}
