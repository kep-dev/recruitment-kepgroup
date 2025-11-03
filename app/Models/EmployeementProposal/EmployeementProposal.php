<?php

namespace App\Models\EmployeementProposal;

use App\Models\User;
use App\Models\JobLevel;
use App\Models\Placement;
use App\Models\JobVacancy;
use App\Models\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EmployeementProposal extends Model
{
    use HasUuids;

    protected $fillable = [
        'application_id',
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'job_vacancy_id',
        'department_id',
        'placement_id',
        'job_level_id',
        'employment_type',
        'work_mode',
        'start_date',
        'end_date',
        'probation_months',
        'base_salary',
        'allowances_json',
        'benefit_ids',
        'notes_json',
        'offer_letter_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'allowances_json' => 'array',
        'benefit_ids' => 'array',
        'notes_json' => 'array',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }

    public function jobLevel()
    {
        return $this->belongsTo(JobLevel::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function approvalOrders()
    {
        return $this->hasMany(ApprovalOrder::class);
    }


}
