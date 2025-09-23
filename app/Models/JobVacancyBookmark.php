<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobVacancyBookmark extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'job_vacancy_id'
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
