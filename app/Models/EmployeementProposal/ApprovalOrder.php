<?php

namespace App\Models\EmployeementProposal;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApprovalOrder extends Model
{
    use HasUuids;

    protected $fillable = [
        'employeement_proposal_id',
        'user_id',
        'order',
    ];

    public function employeement_proposal()
    {
        return $this->belongsTo(EmployeementProposal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approval()
    {
        return $this->morphOne(Approval::class, 'approvable');
    }
}
