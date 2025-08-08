<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobVacancyBenefit extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_vacancy_id',
        'benefit_category_id',
        'description'
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function benefitCategory()
    {
        return $this->belongsTo(BenefitCategory::class);
    }
}
