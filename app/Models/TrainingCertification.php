<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TrainingCertification extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'training_certification_title',
        'institution_name',
        'type',
        'location',
        'start_date',
        'end_date',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
