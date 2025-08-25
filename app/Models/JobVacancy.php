<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JobVacancy extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'work_type_id',
        'employee_type_id',
        'job_level_id',
        'title',
        'slug',
        'image',
        'description',
        'requirements',
        'end_date',
        'status',
        'salary'
    ];

    protected static function booted(): void
    {
        static::creating(function ($jobVacancy) {
            if (empty($jobVacancy->user_id)) {
                $jobVacancy->user_id = auth()->id();
            }

            if (empty($jobVacancy->slug)) {
                $jobVacancy->slug = \Str::slug($jobVacancy->title);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function jobLevel()
    {
        return $this->belongsTo(JobLevel::class);
    }

    public function benefits()
    {
        return $this->hasMany(JobVacancyBenefit::class);
    }

    public function placements()
    {
        return $this->hasMany(JobVacancyPlacement::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_vacancy_id', 'id');
    }

    public function jobVacancyStages()
    {
        return $this->hasMany(JobVacancyStage::class);
    }

}
