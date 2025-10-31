<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationLanguageSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_language_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'language',
        'level',
        'language_id',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
