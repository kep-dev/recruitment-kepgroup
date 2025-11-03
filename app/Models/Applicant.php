<?php

namespace App\Models;

use App\Models\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Applicant extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'nik',
        'date_of_birth',
        'place_of_birth',
        'phone_number',
        'gender',
        'photo',
        'village_code',
        'address_line',
        'postal_code',
    ];

    public function photo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value
                ? Storage::disk('public')->url($value)
                . '?v=' . md5($value . filemtime(Storage::disk('public')->path($value)))
                : asset('images/include/default-user.jpg')
                . '?v=' . md5(filemtime(public_path('images/include/default-user.jpg')))
        );
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_code', 'code');
    }
    public function getDistrictAttribute()
    {
        return $this->village?->district;
    }

    public function getRegencyAttribute()
    {
        return $this->district?->regency;
    }

    public function getProvinceAttribute()
    {
        return $this->regency?->province;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id', 'user_id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'user_id', 'user_id');
    }

    public function latestEducation()
    {
        return $this->hasOne(Education::class, 'user_id', 'user_id')->latestOfMany('graduation_year');
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
