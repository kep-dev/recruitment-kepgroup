<?php

namespace App\Models;

use App\Observers\ApplicationObserver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\PreMedical\PreMedicalSessionApplication;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\ApplicationSnapshot\ApplicationProfileSnapshot;

#[ObservedBy(ApplicationObserver::class)]
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
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
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
        return $this->hasOne(ApplicantTest::class, 'application_id', 'id');
    }

    public function profileSnapshot()
    {
        return $this->hasOne(ApplicationProfileSnapshot::class);
    }

    public function interviewSessionApplications()
    {
        return $this->hasMany(InterviewSessionApplication::class, 'application_id', 'id');
    }

    public function preMedicalSessionApplications()
    {
        return $this->hasMany(PreMedicalSessionApplication::class, 'application_id', 'id');
    }

    public function applicantPsychotest()
    {
        return $this->hasOne(ApplicantTest::class, 'application_id')
            ->whereHas('jobVacancyTest', function ($q) {
                $q->where('type', 'psychotest');
            });
    }
}
