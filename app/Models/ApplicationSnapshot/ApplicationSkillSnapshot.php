<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationSkillSnapshot extends Model
{
     use HasUuids;

    protected $table = 'application_skill_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'skill',
        'skill_id',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceSkill()
    {
        return $this->belongsTo(Skill::class, 'source_skill_id');
    }
}
