<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalSupportingExamination extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'complete_blood',
        'colesterol',
        'blood_sugar',
        'gout',
        'ro',
        'others',
    ];

    public function preMedicalResult()
    {
        return $this->belongsTo(PreMedicalResult::class);
    }
}
