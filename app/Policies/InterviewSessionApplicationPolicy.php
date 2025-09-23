<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\InterviewSessionApplication;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterviewSessionApplicationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:InterviewSessionApplication');
    }

    public function view(AuthUser $authUser, InterviewSessionApplication $interviewSessionApplication): bool
    {
        return $authUser->can('View:InterviewSessionApplication');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:InterviewSessionApplication');
    }

    public function update(AuthUser $authUser, InterviewSessionApplication $interviewSessionApplication): bool
    {
        return $authUser->can('Update:InterviewSessionApplication');
    }

    public function delete(AuthUser $authUser, InterviewSessionApplication $interviewSessionApplication): bool
    {
        return $authUser->can('Delete:InterviewSessionApplication');
    }

    public function restore(AuthUser $authUser, InterviewSessionApplication $interviewSessionApplication): bool
    {
        return $authUser->can('Restore:InterviewSessionApplication');
    }

    public function forceDelete(AuthUser $authUser, InterviewSessionApplication $interviewSessionApplication): bool
    {
        return $authUser->can('ForceDelete:InterviewSessionApplication');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:InterviewSessionApplication');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:InterviewSessionApplication');
    }

    public function replicate(AuthUser $authUser, InterviewSessionApplication $interviewSessionApplication): bool
    {
        return $authUser->can('Replicate:InterviewSessionApplication');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:InterviewSessionApplication');
    }

}