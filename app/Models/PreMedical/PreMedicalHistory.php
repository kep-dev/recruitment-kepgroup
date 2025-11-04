<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreMedicalHistory extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'complaint',
        'anamesis',
        'personal_history',
        'family_history',
        'allergies',
        'current_medications',
        'past_surgeries',
        'smoking_status',
        'alcohol_use',
        'other_notes',
    ];

    public function preMedicalResult(): BelongsTo
    {
        return $this->belongsTo(PreMedicalResult::class);
    }
}
