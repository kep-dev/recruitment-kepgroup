<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalPhysical extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'height_cm',
        'weight_kg',
        'bp_systolic',
        'bp_diastolic',
        'heart_rate_bpm',
        'resp_rate_per_min',
        'temperature_c',
        'head_neck',
        'chest_heart',
        'chest_lung',
        'abdomen_liver',
        'abdomen_spleen',
        'extremities',
        'others',
        'bmi',
        'blood_type'
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
