<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalDentalFinding extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_dental_id',
        'dental_teeth_id',
        'dental_status_id',
        'surface',
        'severity',
        'notes',
    ];

    public function preMedicalDental()
    {
        return $this->belongsTo(PreMedicalDental::class);
    }

    public function dentalTeeth()
    {
        return $this->belongsTo(DentalTeeth::class);
    }

    public function dentalStatus()
    {
        return $this->belongsTo(DentalStatus::class);
    }
}
