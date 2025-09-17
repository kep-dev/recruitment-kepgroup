<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ApplicantAnswer extends Model
{
    use HasUuids;

    protected $fillable = [
        'applicant_test_attempt_id',
        'question_id',
        'selected_choice_id',
        'answer_text',
        'answer_json',
        'is_correct',
        'score',
        'answered_at',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function questionChoice()
    {
        return $this->belongsTo(QuestionChoice::class, 'selected_choice_id')
        ->withDefault([
            'choice_text' => '',
            'choice_label' => '',
        ]);
    }

    public function applicantTestAttempt()
    {
        return $this->belongsTo(ApplicantTestAttempt::class);
    }
}
