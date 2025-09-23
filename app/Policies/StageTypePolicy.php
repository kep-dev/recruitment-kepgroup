<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StageType;
use Illuminate\Auth\Access\HandlesAuthorization;

class StageTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StageType');
    }

    public function view(AuthUser $authUser, StageType $stageType): bool
    {
        return $authUser->can('View:StageType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StageType');
    }

    public function update(AuthUser $authUser, StageType $stageType): bool
    {
        return $authUser->can('Update:StageType');
    }

    public function delete(AuthUser $authUser, StageType $stageType): bool
    {
        return $authUser->can('Delete:StageType');
    }

    public function restore(AuthUser $authUser, StageType $stageType): bool
    {
        return $authUser->can('Restore:StageType');
    }

    public function forceDelete(AuthUser $authUser, StageType $stageType): bool
    {
        return $authUser->can('ForceDelete:StageType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StageType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StageType');
    }

    public function replicate(AuthUser $authUser, StageType $stageType): bool
    {
        return $authUser->can('Replicate:StageType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StageType');
    }

}