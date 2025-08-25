<?php

namespace App\Models;


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

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->attributes['type'] ?? null) {
                'multiple_choice' => 'Pilihan Ganda',
                'essay'           => 'Essay',
                'true_false'      => 'Salah Benar',
                'fill_in_blank'   => 'Isi Kosong',
                'matching'        => 'Pencocokan',
                default           => ucfirst(str_replace('_', ' ', $this->attributes['type'] ?? '')),
            }
        );
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
