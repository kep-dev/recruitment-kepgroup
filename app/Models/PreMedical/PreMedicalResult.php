<?php

namespace App\Models\PreMedical;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Observers\PreMedicalResultObserver;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(PreMedicalResultObserver::class)]
class PreMedicalResult extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_session_application_id',
        'overall_status',
        'overall_note',
        'examined_by',
        'examined_at',
    ];

    public function examinedBy()
    {
        return $this->belongsTo(User::class, 'examined_by');
    }

    public function preMedicalSessionApplication(): BelongsTo
    {
        return $this->belongsTo(PreMedicalSessionApplication::class);
    }

    public function preMedicalDental()
    {
        return $this->hasOne(PreMedicalDental::class, 'pre_medical_result_id', 'id');
    }

    public function preMedicalEye()
    {
        return $this->hasOne(PreMedicalEye::class, 'pre_medical_result_id', 'id');
    }

    public function preMedicalEnt()
    {
        return $this->hasOne(PreMedicalEnt::class, 'pre_medical_result_id', 'id');
    }

    public function preMedicalObgyn()
    {
        return $this->hasOne(PreMedicalObgyn::class, 'pre_medical_result_id', 'id');
    }

    public function preMedicalHistory()
    {
        return $this->hasOne(PreMedicalHistory::class, 'pre_medical_result_id', 'id');
    }

    public function preMedicalPhysical()
    {
        return $this->hasOne(PreMedicalPhysical::class, 'pre_medical_result_id', 'id');
    }

    public function preMedicalSupportingExamination()
    {
        return $this->hasOne(PreMedicalSupportingExamination::class, 'pre_medical_result_id', 'id');
    }
}
