<?php

namespace App\Models;


use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Question extends Model
{
    use HasUuids;

    protected $fillable = [
        'test_id',
        'question_text',
        'type',
        'points',
    ];

    protected function casts()
    {
        return [
            'type' => QuestionType::class
        ];
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class);
    }
}
