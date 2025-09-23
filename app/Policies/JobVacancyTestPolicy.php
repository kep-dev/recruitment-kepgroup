<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\JobVacancyTest;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobVacancyTestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:JobVacancyTest');
    }

    public function view(AuthUser $authUser, JobVacancyTest $jobVacancyTest): bool
    {
        return $authUser->can('View:JobVacancyTest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:JobVacancyTest');
    }

    public function update(AuthUser $authUser, JobVacancyTest $jobVacancyTest): bool
    {
        return $authUser->can('Update:JobVacancyTest');
    }

    public function delete(AuthUser $authUser, JobVacancyTest $jobVacancyTest): bool
    {
        return $authUser->can('Delete:JobVacancyTest');
    }

    public function restore(AuthUser $authUser, JobVacancyTest $jobVacancyTest): bool
    {
        return $authUser->can('Restore:JobVacancyTest');
    }

    public function forceDelete(AuthUser $authUser, JobVacancyTest $jobVacancyTest): bool
    {
        return $authUser->can('ForceDelete:JobVacancyTest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:JobVacancyTest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:JobVacancyTest');
    }

    public function replicate(AuthUser $authUser, JobVacancyTest $jobVacancyTest): bool
    {
        return $authUser->can('Replicate:JobVacancyTest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:JobVacancyTest');
    }

}