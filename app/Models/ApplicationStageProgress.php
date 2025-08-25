<?php

namespace App\Models;

use App\Enums\status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationStageProgress extends Model
{
    use HasUuids;

    protected $fillable = [
        'application_id',
        'job_vacancy_stage_id',
        'status',
        'started_at',
        'decided_at',
        'decided_by',
        'note',
        'score',
    ];

    protected static function booted()
    {
        static::created(function ($progress) {
            $progress->application->statusHistories()->create([
                'job_vacancy_stage_id' => $progress->job_vacancy_stage_id,
                'from_status' => 'pending',
                'to_status'   => $progress->status,
                'changed_by'  => auth()->id(),
                'note'        => $progress->note,
            ]);
        });

        static::updated(function ($progress) {
            if ($progress->wasChanged('status')) {
                $progress->application->statusHistories()->create([
                    'job_vacancy_stage_id' => $progress->job_vacancy_stage_id,
                    'from_status' => $progress->getOriginal('status'),
                    'to_status'   => $progress->status,
                    'changed_by'  => auth()->id(),
                    'note'        => $progress->note,
                ]);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'status' => status::class
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


    public function decidedBy()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
