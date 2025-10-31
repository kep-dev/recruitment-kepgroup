<?php

namespace App\Services;


use Carbon\Carbon;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationSnapshot\ApplicationSkillSnapshot;
use App\Models\ApplicationSnapshot\ApplicationSalarySnapshot;
use App\Models\ApplicationSnapshot\ApplicationProfileSnapshot;
use App\Models\ApplicationSnapshot\ApplicationLanguageSnapshot;
use App\Models\ApplicationSnapshot\ApplicationEducationSnapshot;
use App\Models\ApplicationSnapshot\ApplicationAchievementSnapshot;
use App\Models\ApplicationSnapshot\ApplicationSocialMediaSnapshot;
use App\Models\ApplicationSnapshot\ApplicationWorkExperienceSnapshot;
use App\Models\ApplicationSnapshot\ApplicationFunctionOfInterestSnapshot;
use App\Models\ApplicationSnapshot\ApplicationTrainingCertificationSnapshot;
use App\Models\ApplicationSnapshot\ApplicationOrganizationalExperienceSnapshot;

class ApplicationSnapshotService
{
    /**
     * Buat snapshot lengkap untuk sebuah application.
     * Idempotent: tidak membuat snapshot jika sudah ada.
     */
    public function createFor(Application $application): ?ApplicationProfileSnapshot
    {
        // Cek jika sudah ada snapshot untuk application ini
        if ($application->profileSnapshot()->exists()) {
            return $application->profileSnapshot;
        }

        // Eager-load relasi user agar hemat query
        $application->load([
            'user.educations',
            'user.workExperiences',
            'user.organizationalExperiences',
            'user.trainingCertifications',
            'user.achievements',           // sesuai penamaan tabel sumbermu
            'user.languages',
            'user.skills',
            'user.socialMedias',
            'user.functionOfInterests',
            'user.salary',
        ]);

        $user = $application->user;

        return DB::transaction(function () use ($application, $user) {

            // ---- Hitung metrik turunan (opsional) ----
            $totalExperienceYears = 0.0;
            foreach ($user->workExperiences as $we) {
                if (!$we->start_date) continue;
                $start = Carbon::parse($we->start_date);
                $end   = $we->currently_working
                    ? now()
                    : ($we->end_date ? Carbon::parse($we->end_date) : now());

                $days = max(0, $start->diffInDays($end));
                $totalExperienceYears += $days / 365;
            }

            // (opsional) pendidikan tertinggi
            $highestEdu = $user->educations
                ->sortByDesc('graduation_year')
                ->first();

            // ---- Header snapshot ----
            /** @var ApplicationProfileSnapshot $snapshot */
            $snapshot = ApplicationProfileSnapshot::create([
                'application_id' => $application->id,
                'user_id'        => $user->id,
                'captured_at'    => now(),
                'source_note'    => 'auto on apply',
                'extra'          => [
                    'total_experience_years' => round($totalExperienceYears, 2),
                    'highest_education_level' => $highestEdu->education_level ?? null,
                ],
            ]);

            // ---- Detail: Education (copy-all) ----
            foreach ($user->educations as $edu) {
                ApplicationEducationSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'education_level'   => $edu->education_level,
                    'major'             => $edu->major,
                    'university'        => $edu->university,
                    'location'          => $edu->location,
                    'graduation_year'   => $edu->graduation_year,
                    'gpa'               => $edu->gpa,
                    'source_education_id' => $edu->id,
                ]);
            }

            // ---- Detail: Work Experiences (copy-all) ----
            foreach ($user->workExperiences as $we) {
                ApplicationWorkExperienceSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'job_title'          => $we->job_title,
                    'company_name'       => $we->company_name,
                    'job_position'       => $we->job_position,
                    'industry'           => $we->industry,
                    'start_date'         => $we->start_date,
                    'end_date'           => $we->end_date,
                    'currently_working'  => (bool) $we->currently_working,
                    'description'        => $we->description,
                    'source_work_experience_id' => $we->id,
                ]);
            }

            // ---- Detail: Organizational Experiences (copy-all) ----
            foreach ($user->organizationalExperiences as $ox) {
                ApplicationOrganizationalExperienceSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'organization_name' => $ox->organization_name,
                    'position'          => $ox->position,
                    'level'             => $ox->level,
                    'start_date'        => $ox->start_date,
                    'end_date'          => $ox->end_date,
                    'source_organizational_experience_id' => $ox->id,
                ]);
            }

            // ---- Detail: Trainings/Certifications (copy-all) ----
            foreach ($user->trainingCertifications as $tc) {
                ApplicationTrainingCertificationSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'training_certification_title' => $tc->training_certification_title,
                    'institution_name'             => $tc->institution_name,
                    'type'                         => $tc->type,
                    'location'                     => $tc->location,
                    'start_date'                   => $tc->start_date,
                    'end_date'                     => $tc->end_date,
                    'description'                  => $tc->description,
                    'source_training_certification_id' => $tc->id,
                ]);
            }

            // ---- Detail: Achievements (copy-all) ----
            foreach ($user->achievements as $ach) { // penamaan sesuai tabel sumbermu
                ApplicationAchievementSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'achievement_name'     => $ach->achievement_name,
                    'organization_name'    => $ach->organization_name,
                    'year'                 => $ach->year,
                    'source_achievement_id' => $ach->id,
                ]);
            }

            // ---- Detail: Languages (copy-all) ----
            foreach ($user->languages as $lang) {
                ApplicationLanguageSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'language'           => $lang->language,
                    'level'              => $lang->level,
                    'source_language_id' => $lang->id,
                ]);
            }

            // ---- Detail: Skills (copy-all) ----
            foreach ($user->skills as $sk) {
                ApplicationSkillSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'skill'            => $sk->skill,
                    'source_skill_id'  => $sk->id,
                ]);
            }

            // ---- Detail: Social Medias (copy-all) ----
            foreach ($user->socialMedias as $sm) {
                ApplicationSocialMediaSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'name'                 => $sm->name,
                    'url'                  => $sm->url,
                    'source_social_media_id' => $sm->id,
                ]);
            }

            // ---- Detail: Function of Interests (copy-all) ----
            foreach ($user->functionOfInterests as $foi) {
                ApplicationFunctionOfInterestSnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'function_of_interest'     => $foi->function_of_interest,
                    'source_function_of_interest_id' => $foi->id,
                ]);
            }

            // ---- Salary (ambil terbaru satu baris; ubah ke loop jika ingin copy-all) ----
            $latestSalary = $user->salary;
            if ($latestSalary) {
                ApplicationSalarySnapshot::create([
                    'application_snapshot_id' => $snapshot->id,
                    'expected_salary'   => $latestSalary->expected_salary,
                    'current_salary'    => $latestSalary->current_salary,
                    'currency'          => 'IDR',
                    'source_salary_id'  => $latestSalary->id,
                ]);
            }

            return $snapshot;
        });
    }
}
