<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestQuestion extends Model
{
    use HasUuids;

    protected $fillable = [
        'psychotest_form_id',
        'number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function psychotestForm()
    {
        return $this->belongsTo(PsychotestForm::class, 'psychotest_form_id');
    }

    public function options()
    {
        return $this->hasMany(PsychotestQuestionOption::class, 'psychotest_question_id');
    }

}
