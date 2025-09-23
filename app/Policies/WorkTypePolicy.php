<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WorkType;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WorkType');
    }

    public function view(AuthUser $authUser, WorkType $workType): bool
    {
        return $authUser->can('View:WorkType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WorkType');
    }

    public function update(AuthUser $authUser, WorkType $workType): bool
    {
        return $authUser->can('Update:WorkType');
    }

    public function delete(AuthUser $authUser, WorkType $workType): bool
    {
        return $authUser->can('Delete:WorkType');
    }

    public function restore(AuthUser $authUser, WorkType $workType): bool
    {
        return $authUser->can('Restore:WorkType');
    }

    public function forceDelete(AuthUser $authUser, WorkType $workType): bool
    {
        return $authUser->can('ForceDelete:WorkType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WorkType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WorkType');
    }

    public function replicate(AuthUser $authUser, WorkType $workType): bool
    {
        return $authUser->can('Replicate:WorkType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WorkType');
    }

}