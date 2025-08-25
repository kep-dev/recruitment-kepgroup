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
}
