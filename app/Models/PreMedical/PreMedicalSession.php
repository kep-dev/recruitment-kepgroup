<?php

namespace App\Models\PreMedical;

use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PreMedicalSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_id',
        'title',
        'scheduled_at',
        'scheduled_end_at',
        'location',
        'instruction',
        'status',
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function preMedicalSessionApplications()
    {
        return $this->hasMany(PreMedicalSessionApplication::class);
    }
}
