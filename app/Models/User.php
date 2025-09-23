<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redirect;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->hasAnyRole(['super_admin', 'interviewer'])) {
            return true;
        }

        Redirect::to(url()->previous() ?: '/');
        return false;
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function applicant()
    {
        return $this->hasOne(Applicant::class)->withDefault([
            'nik' => '-',
            'date_of_birth' => '-',
            'phone_number' => '-',
            'gender' => '-',
            'city' => '-',
            'province' => '-',
        ]);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function latestEducation()
    {
        return $this->hasOne(Education::class)->latestOfMany();
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function organizationalExperiences()
    {
        return $this->hasMany(OrganizationalExperience::class);
    }

    public function trainingCertifications()
    {
        return $this->hasMany(TrainingCertification::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievment::class);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function socialMedias()
    {
        return $this->hasMany(SocialMedia::class);
    }

    public function functionOfInterests()
    {
        return $this->hasMany(FunctionOfInterest::class);
    }

    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function jobVacancyBookmarks()
    {
        return $this->hasMany(JobVacancyBookmark::class, 'user_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'id');
    }
}
