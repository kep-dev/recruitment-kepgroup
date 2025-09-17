<?php

namespace App\Models;

use App\Enums\status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicantTestAttempt extends Model
{
    use HasUuids;

    protected $fillable = [
        'applicant_test_id',
        'job_vacancy_test_item_id',
        'test_id',
        'attempt_no',
        'status',
        'ended_reason',
        'score',
        'started_at',
        'deadline_at',
        'submitted_at',
        'random_seed',
    ];

    protected function casts()
    {
        return [
            'status' => status::class,
            'ended_reason' => status::class
        ];
    }

    public function jobVacancyTestItem()
    {
        return $this->belongsTo(JobVacancyTestItem::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function applicantTest()
    {
        return $this->belongsTo(ApplicantTest::class);
    }

    public function attemptQuestions()
    {
        return $this->hasMany(ApplicantAttemptQuestion::class, 'applicant_test_attempt_id', 'id');
    }

}
