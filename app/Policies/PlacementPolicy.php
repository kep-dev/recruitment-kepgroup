<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Placement;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacementPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Placement');
    }

    public function view(AuthUser $authUser, Placement $placement): bool
    {
        return $authUser->can('View:Placement');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Placement');
    }

    public function update(AuthUser $authUser, Placement $placement): bool
    {
        return $authUser->can('Update:Placement');
    }

    public function delete(AuthUser $authUser, Placement $placement): bool
    {
        return $authUser->can('Delete:Placement');
    }

    public function restore(AuthUser $authUser, Placement $placement): bool
    {
        return $authUser->can('Restore:Placement');
    }

    public function forceDelete(AuthUser $authUser, Placement $placement): bool
    {
        return $authUser->can('ForceDelete:Placement');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Placement');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Placement');
    }

    public function replicate(AuthUser $authUser, Placement $placement): bool
    {
        return $authUser->can('Replicate:Placement');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Placement');
    }

}