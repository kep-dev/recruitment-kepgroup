<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Application extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'job_vacancy_id',
        'current_stage_id',
        'applied_at',
        'final_status',
        'note'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'user_id', 'user_id');
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentStage()
    {
        return $this->belongsTo(JobVacancyStage::class, 'current_stage_id');
    }

    public function stageProgresses()
    {
        return $this->hasMany(ApplicationStageProgress::class);
    }

    public function latestStageProgress()
    {
        return $this->hasOne(ApplicationStageProgress::class)->latestOfMany();
    }

    public function statusHistories()
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    public function applicantTests()
    {
        return $this->hasOne(ApplicantTest::class, 'application_id');
    }
}
