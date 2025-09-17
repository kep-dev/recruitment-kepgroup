<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InterviewScale extends Model
{
    use HasUuids;

    protected $fillable = [
        'interview_criteria_id',
        'label',
        'value',
        'order',
    ];

    public function interviewCriteria()
    {
        return $this->belongsTo(InterviewCriteria::class, 'interview_criteria_id');
    }
}
