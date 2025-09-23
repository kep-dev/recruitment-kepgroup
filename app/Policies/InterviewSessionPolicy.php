<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\InterviewSession;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterviewSessionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:InterviewSession');
    }

    public function view(AuthUser $authUser, InterviewSession $interviewSession): bool
    {
        return $authUser->can('View:InterviewSession');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:InterviewSession');
    }

    public function update(AuthUser $authUser, InterviewSession $interviewSession): bool
    {
        return $authUser->can('Update:InterviewSession');
    }

    public function delete(AuthUser $authUser, InterviewSession $interviewSession): bool
    {
        return $authUser->can('Delete:InterviewSession');
    }

    public function restore(AuthUser $authUser, InterviewSession $interviewSession): bool
    {
        return $authUser->can('Restore:InterviewSession');
    }

    public function forceDelete(AuthUser $authUser, InterviewSession $interviewSession): bool
    {
        return $authUser->can('ForceDelete:InterviewSession');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:InterviewSession');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:InterviewSession');
    }

    public function replicate(AuthUser $authUser, InterviewSession $interviewSession): bool
    {
        return $authUser->can('Replicate:InterviewSession');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:InterviewSession');
    }

}