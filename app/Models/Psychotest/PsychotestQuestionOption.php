<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestQuestionOption extends Model
{
    use HasUuids;

    protected $fillable = [
        'psychotest_question_id',
        'label',
        'statement',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function psychotestQuestion()
    {
        return $this->belongsTo(PsychotestQuestion::class);
    }

    public function mappings()
    {
        return $this->hasMany(PsychotestOptionCharacteristicMapping::class, 'option_id');
    }

}
