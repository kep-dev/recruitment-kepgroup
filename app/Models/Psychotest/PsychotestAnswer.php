<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestAnswer extends Model
{
    use HasUuids;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'option_id',
    ];

    public function attempt()
    {
        return $this->belongsTo(PsychotestAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(PsychotestQuestion::class);
    }

    public function option()
    {
        return $this->belongsTo(PsychotestQuestionOption::class);
    }
}
