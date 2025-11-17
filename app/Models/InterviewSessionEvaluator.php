<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InterviewSessionEvaluator extends Model
{
    use HasUuids;

    protected $fillable = [
        'interview_session_id',
        'user_id',
        'role',
    ];

    public function interviewSession()
    {
        return $this->belongsTo(InterviewSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluations()
    {
        return $this->hasMany(InterviewEvaluation::class, 'interview_session_evaluator_id');
    }
}
