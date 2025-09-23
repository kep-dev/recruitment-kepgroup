<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InterviewEvaluationScore extends Model
{
    use HasUuids;
    protected $fillable = [
        'interview_evaluation_id',
        'interview_criteria_id',
        'interview_scale_id',
        'scale_label_snapshot',
        'scale_value_snapshot',
        'score_numeric',
        'comment',
    ];

    public function evaluation()
    {
        return $this->belongsTo(InterviewEvaluation::class, 'interview_evaluation_id');
    }

    public function criteria()
    {
        return $this->belongsTo(InterviewCriteria::class, 'interview_criteria_id');
    }

    public function scaleOption()
    {
        return $this->belongsTo(InterviewScale::class, 'interview_scale_id');
    }
}
