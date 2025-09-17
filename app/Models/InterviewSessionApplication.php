<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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

    public function interviewSession()
    {
        return $this->belongsTo(InterviewSession::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

}
