<?php

namespace App\Models;

use App\Models\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Applicant extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'nik',
        'date_of_birth',
        'phone_number',
        'gender',
        'city',
        'province',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'user_id', 'user_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'user_id', 'user_id');
    }

    public function organizationalExperiences()
    {
        return $this->hasMany(OrganizationalExperience::class, 'user_id', 'user_id');
    }

    public function trainingCertifications()
    {
        return $this->hasMany(TrainingCertification::class, 'user_id', 'user_id');
    }

    public function achievements()
    {
        return $this->hasMany(Achievment::class, 'user_id', 'user_id');
    }

    public function languages()
    {
        return $this->hasMany(Language::class, 'user_id', 'user_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'user_id', 'user_id');
    }

    public function socialMedias()
    {
        return $this->hasMany(SocialMedia::class, 'user_id', 'user_id');
    }

    public function functionOfInterests()
    {
        return $this->hasMany(FunctionOfInterest::class, 'user_id', 'user_id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'user_id', 'user_id');
    }
}
