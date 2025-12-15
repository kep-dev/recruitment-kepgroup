<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable  = [
        'user_id',
        'job_title',
        'company_name',
        'job_position',
        'industry',
        'start_date',
        'end_date',
        'currently_working',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
