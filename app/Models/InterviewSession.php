<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InterviewSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_id',
        'interview_id',
        'title',
        'scheduled_at',
        'scheduled_end_at',
        'default_mode',
        'default_location',
        'default_meeting_link',
        'status',
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function interviewForm()
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }

    public function interviewApplications()
    {
        return $this->hasMany(InterviewSessionApplication::class, 'interview_session_id');
    }

    public function interviewEvaluators()
    {
        return $this->hasMany(InterviewSessionEvaluator::class, 'interview_session_id');
    }
}
