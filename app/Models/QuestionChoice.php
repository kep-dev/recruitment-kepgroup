<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    use HasUuids;

    protected $fillable  = [
        'question_id',
        'choice_label',
        'choice_text',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
