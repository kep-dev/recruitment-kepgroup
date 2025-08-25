<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function jobVacancyTest()
    {
        return $this->belongsTo(JobVacancyTest::class);
    }

}
