<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InterviewEvaluation extends Model
{
    use HasUuids;
    protected $fillable = [
        'interview_session_application_id',
        'interview_session_evaluator_id',
        'total_score',
        'recommendation',
        'overall_comment',
        'submitted_at',
    ];

    public function interviewSessionApplication()
    {
        return $this->belongsTo(InterviewSessionApplication::class, 'interview_session_application_id');
    }

    public function sessionEvaluator()
    {
        return $this->belongsTo(InterviewSessionEvaluator::class, 'interview_session_evaluator_id');
    }

    public function evaluatorUser()
    {
        return $this->hasOneThrough(
            User::class,
            InterviewSessionEvaluator::class,
            'id',           // FK di interview_session_evaluators
            'id',           // PK di users
            'interview_session_evaluator_id', // FK di evaluasi
            'user_id'       // FK di evaluators
        );
    }

    public function scores()
    {
        return $this->hasMany(InterviewEvaluationScore::class, 'interview_evaluation_id');
    }
}
