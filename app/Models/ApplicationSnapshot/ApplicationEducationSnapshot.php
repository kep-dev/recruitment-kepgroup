<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\ApplicationSnapshot\ApplicationProfileSnapshot;

class ApplicationEducationSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_education_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'education_level',
        'major',
        'university',
        'location',
        'graduation_year',
        'gpa',
        'education_id',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
        'gpa' => 'decimal:2',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceEducation()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }
}
