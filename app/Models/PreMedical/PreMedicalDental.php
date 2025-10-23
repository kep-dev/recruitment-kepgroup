<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalDental extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'general_condition',
        'occlusion',
        'others',
    ];

    public function preMedicalResult()
    {
        return $this->belongsTo(PreMedicalResult::class);
    }

    public function preMedicalDentalFindings()
    {
        return $this->hasMany(PreMedicalDentalFinding::class);
    }
}
