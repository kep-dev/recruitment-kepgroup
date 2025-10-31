<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ExamClientEvent extends Model
{
    use HasUuids;

    protected $fillable = [
        'applicant_test_id',
        'job_vacancy_test_item_id',
        'event',
        'meta',
    ];

    protected function casts()
    {
        return [
            'meta' => 'array',
        ];
    }

    public function applicantTest()
    {
        return $this->belongsTo(ApplicantTest::class, 'applicant_test_id');
    }

    public function jobVacancyTestItem()
    {
        return $this->belongsTo(JobVacancyTestItem::class, 'job_vacancy_test_item_id');
    }

}
