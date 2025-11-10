<?php

namespace App\Models\PreMedical;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PreMedicalSessionApplication extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_session_id',
        'application_id',
        'timeslot_start',
        'timeslot_end',
        'status',
        'scheduled',
        'result_status',
        'result_note',
        'result_file_path',
        'reviewed_by',
        'reviewed_at',
    ];

    public function preMedicalSession()
    {
        return $this->belongsTo(PreMedicalSession::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function preMedicalResult()
    {
        return $this->hasOne(PreMedicalResult::class, 'pre_medical_session_application_id');
    }
}
