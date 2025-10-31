<?php

namespace App\Models\ApplicationSnapshot;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrganizationalExperience;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationOrganizationalExperienceSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_organizational_experience_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'organization_name',
        'position',
        'level',
        'start_date',
        'end_date',
        'organizational_experience_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceOrganizationalExperience()
    {
        return $this->belongsTo(OrganizationalExperience::class, 'source_organizational_experience_id');
    }
}
