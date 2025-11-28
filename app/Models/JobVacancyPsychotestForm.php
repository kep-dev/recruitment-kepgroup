<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Psychotest\PsychotestForm;
use App\Models\Psychotest\PsychotestAttempt;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JobVacancyPsychotestForm extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_test_id',
        'psychotest_form_id',
        'order',
        'duration_minutes',
    ];

    protected function casts()
    {
        return [
            'order' => 'integer',
            'duration_minutes' => 'integer',
        ];
    }

    public function jobVacancyTest()
    {
        return $this->belongsTo(JobVacancyTest::class, 'job_vacancy_test_id', 'id');
    }

    public function psychotestForm()
    {
        return $this->belongsTo(PsychotestForm::class, 'psychotest_form_id', 'id');
    }

    public function attempts()
    {
        return $this->hasMany(PsychotestAttempt::class, 'form_id');
    }

    public function finishedAttempts()
    {
        return $this->attempts()->whereIn('status', ['submitted', 'graded', 'expired']);
    }
}
