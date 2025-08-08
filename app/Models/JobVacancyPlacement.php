<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobVacancyPlacement extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_id',
        'placement_id'
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }
}
