<?php

namespace App\Models;

use App\Enums\status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationStatusHistory extends Model
{
    use HasUuids;

    protected $fillable  = [
        'application_id',
        'job_vacancy_stage_id',
        'from_status',
        'to_status',
        'changed_by',
        'note',
        'changed_at',
    ];

    protected function casts(): array
    {
        return [
            'from_status' => status::class,
            'to_status'   => status::class
        ];
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function jobVacancyStage()
    {
        return $this->belongsTo(JobVacancyStage::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
