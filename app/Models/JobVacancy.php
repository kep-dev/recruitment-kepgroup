<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JobVacancy extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

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
        'start_date',
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
                $jobVacancy->slug = Str::slug($jobVacancy->title);
            }
        });
    }

    protected function casts()
    {
        return [
            'status' => 'boolean',
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
        ];
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            $value
                ? Storage::disk('public')->url($value) . '?v=' . md5($value . filemtime(Storage::disk('public')->path($value)))
                : null
        );
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
