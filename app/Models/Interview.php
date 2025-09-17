<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'description'
    ];

    public function criterias()
    {
        return $this->hasMany(InterviewCriteria::class, 'interview_id');
    }

}
