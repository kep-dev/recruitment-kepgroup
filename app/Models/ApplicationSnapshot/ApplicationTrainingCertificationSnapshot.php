<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\TrainingCertification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationTrainingCertificationSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_training_certification_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'training_certification_title',
        'institution_name',
        'type',
        'location',
        'start_date',
        'end_date',
        'description',
        'training_certification_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceTrainingCertification()
    {
        return $this->belongsTo(TrainingCertification::class, 'training_certification_id');
    }
}
