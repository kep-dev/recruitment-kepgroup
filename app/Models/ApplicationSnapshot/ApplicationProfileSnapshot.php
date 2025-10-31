<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\ApplicationSnapshot\ApplicationSkillSnapshot;
use App\Models\ApplicationSnapshot\ApplicationSalarySnapshot;
use App\Models\ApplicationSnapshot\ApplicationLanguageSnapshot;
use App\Models\ApplicationSnapshot\ApplicationEducationSnapshot;
use App\Models\ApplicationSnapshot\ApplicationAchievementSnapshot;
use App\Models\ApplicationSnapshot\ApplicationSocialMediaSnapshot;
use App\Models\ApplicationSnapshot\ApplicationWorkExperienceSnapshot;
use App\Models\ApplicationSnapshot\ApplicationFunctionOfInterestSnapshot;
use App\Models\ApplicationSnapshot\ApplicationTrainingCertificationSnapshot;
use App\Models\ApplicationSnapshot\ApplicationOrganizationalExperienceSnapshot;

class ApplicationProfileSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_profile_snapshots';

    protected $fillable = [
        'application_id',
        'user_id',
        'captured_at',
        'source_note',
        'extra',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
        'extra' => 'array',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // child snapshots
    public function educations()
    {
        return $this->hasMany(ApplicationEducationSnapshot::class, 'application_snapshot_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(ApplicationWorkExperienceSnapshot::class, 'application_snapshot_id');
    }

    public function organizationalExperiences()
    {
        return $this->hasMany(ApplicationOrganizationalExperienceSnapshot::class, 'application_snapshot_id');
    }

    public function trainings()
    {
        return $this->hasMany(ApplicationTrainingCertificationSnapshot::class, 'application_snapshot_id');
    }

    public function achievements()
    {
        return $this->hasMany(ApplicationAchievementSnapshot::class, 'application_snapshot_id');
    }

    public function languages()
    {
        return $this->hasMany(ApplicationLanguageSnapshot::class, 'application_snapshot_id');
    }

    public function skills()
    {
        return $this->hasMany(ApplicationSkillSnapshot::class, 'application_snapshot_id');
    }

    public function socialMedias()
    {
        return $this->hasMany(ApplicationSocialMediaSnapshot::class, 'application_snapshot_id');
    }

    public function functionOfInterests()
    {
        return $this->hasMany(ApplicationFunctionOfInterestSnapshot::class, 'application_snapshot_id');
    }

    public function salary()
    {
        return $this->hasOne(ApplicationSalarySnapshot::class, 'application_snapshot_id');
    }
}
