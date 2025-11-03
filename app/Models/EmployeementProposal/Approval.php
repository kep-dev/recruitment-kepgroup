<?php

namespace App\Models\EmployeementProposal;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Approval extends Model
{
    use HasUuids;

    protected $fillable  = [
        'approvable_id',
        'approvable_type',
        'approved_by',
        'status',
        'keterangan',
        'approved_at',
    ];

    public function approvable()
    {
        return $this->morphTo();
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
