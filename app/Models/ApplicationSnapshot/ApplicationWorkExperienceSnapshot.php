<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\WorkExperience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationWorkExperienceSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_work_experience_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'job_title',
        'company_name',
        'job_position',
        'industry',
        'start_date',
        'end_date',
        'currently_working',
        'description',
        'work_experience_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'currently_working' => 'boolean',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceWorkExperience()
    {
        return $this->belongsTo(WorkExperience::class, 'work_experience_id');
    }
}
