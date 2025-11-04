<?php

namespace App\Models;

use App\Enums\status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicantTest extends Model
{
    use HasUuids;

    protected $fillable = [
        'application_id',
        'job_vacancy_test_id',
        'access_token',
        'status',
        'started_at',
        'completed_at',
        'total_score',
    ];

    protected function casts(): array
    {
        return [
            'status' => status::class,
            'started_at'  => 'datetime:Asia/Jakarta',
            'completed_at' => 'datetime:Asia/Jakarta',
        ];
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function jobVacancyTest()
    {
        return $this->belongsTo(JobVacancyTest::class, 'job_vacancy_test_id');
    }

    public function attempts()
    {
        return $this->hasMany(ApplicantTestAttempt::class, 'applicant_test_id');
    }
}
