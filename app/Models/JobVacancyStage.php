<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobVacancyStage extends Model
{
    use HasUuids;

    protected $fillable  = [
        'job_vacancy_id',
        'stage_type_id',
        'order',
        'is_required',
    ];

    public function stageType()
    {
        return $this->belongsTo(StageType::class, 'stage_type_id');
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
