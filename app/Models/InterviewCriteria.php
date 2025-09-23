<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InterviewCriteria extends Model
{
    use HasUuids;

    protected $fillable = [
        'interview_id',
        'label',
        'description',
        'order',
        'weight',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function scales()
    {
        return $this->hasMany(InterviewScale::class, 'interview_criteria_id');
    }

}
