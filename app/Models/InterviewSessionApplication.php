<?php

namespace App\Models;

use App\Enums\status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InterviewSessionApplication extends Model
{
    use HasUuids;

    protected $fillable = [
        'interview_session_id',
        'application_id',
        'mode',
        'location',
        'meeting_link',
        'status',
        'avg_score',
        'recommendation',
    ];

    protected function casts(): array
    {
        return [
            'status' => status::class
        ];
    }

    public function interviewSession()
    {
        return $this->belongsTo(InterviewSession::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function evaluations()
    {
        return $this->hasMany(InterviewEvaluation::class, 'interview_session_application_id');
    }
}
