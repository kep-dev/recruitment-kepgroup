<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalEnt extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'ear',
        'nose',
        'throat',
        'others',
    ];

    public function preMedicalResult()
    {
        return $this->belongsTo(PreMedicalResult::class);
    }

    public function itemChecks()
    {
        return $this->morphMany(PreMedicalItemCheck::class, 'checkable');
    }
}
