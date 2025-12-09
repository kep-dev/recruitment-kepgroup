<?php

namespace App\Models;

use App\Enums\status;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = [
        'total_score',
        'total_score_label'
    ];

    public function totalScore(): Attribute
    {
        return Attribute::get(function () {
            $avg = $this->evaluations()->avg('total_score');

            if ($avg === null) {
                return null;
            }

            return round((float) $avg, 2);
        });
    }

    public function totalScoreLabel(): Attribute
    {
        return Attribute::get(function (): string {
            $score = $this->total_score;

            if ($score === null) {
                return '-';
            }

            $score = (float) $score;

            if ($score === 100.0) {
                return 'Sangat Baik';
            }

            if ($score >= 75.0) {
                return 'Baik';
            }

            if ($score >= 50.0) {
                return 'Cukup';
            }

            return 'Kurang';
        });
    }

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
