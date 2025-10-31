<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationSocialMediaSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_social_media_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'name',
        'url',
        'social_media_id',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceSocialMedia()
    {
        return $this->belongsTo(SocialMedia::class, 'source_social_media_id');
    }
}
