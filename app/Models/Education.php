<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = 'educations';
    protected $fillable = [
        'user_id',
        'education_level',
        'major',
        'university',
        'location',
        'graduation_year',
        'gpa',
        'certificate_number',
        'main_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
