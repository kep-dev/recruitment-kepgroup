<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobVacancyTest extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_id',
        'name',
        'active_from',
        'active_until',
        'is_active',
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function jobVacancyTestItems()
    {
        return $this->hasMany(JobVacancyTestItem::class, 'job_vacancy_test_id');
    }

    public function applicantTests()
    {
        return $this->hasMany(ApplicantTest::class, 'job_vacancy_test_id');
    }
}
