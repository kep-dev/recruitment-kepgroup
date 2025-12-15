<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationalExperience extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'organization_name',
        'position',
        'level',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
