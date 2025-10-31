<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\Achievment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationAchievementSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_achievement_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'achievement_name',
        'organization_name',
        'year',
        'achievement_id',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceAchievement()
    {
        // tabel sumbermu bernama 'achievments'
        return $this->belongsTo(Achievment::class, 'achievement_id');
    }
}
