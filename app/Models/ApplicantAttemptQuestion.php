<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ApplicantAttemptQuestion extends Model
{
    use HasUuids;

    protected $fillable = [
        'applicant_test_attempt_id',
        'question_id',
        'order_index',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function applicantTestAttempt()
    {
        return $this->belongsTo(ApplicantTestAttempt::class);
    }
}
