<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobVacancyTestItem extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_test_id',
        'test_id',
        'number_of_question',
        'duration_in_minutes',
        'order',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function jobVacancyTest()
    {
        return $this->belongsTo(JobVacancyTest::class);
    }

    public function attempts()
    {
        return $this->hasMany(ApplicantTestAttempt::class, 'job_vacancy_test_item_id');
    }

    public function finishedAttempts()
    {
        return $this->attempts()->whereIn('status', ['submitted', 'graded']);
    }
}
