<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EmployeeType;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EmployeeType');
    }

    public function view(AuthUser $authUser, EmployeeType $employeeType): bool
    {
        return $authUser->can('View:EmployeeType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EmployeeType');
    }

    public function update(AuthUser $authUser, EmployeeType $employeeType): bool
    {
        return $authUser->can('Update:EmployeeType');
    }

    public function delete(AuthUser $authUser, EmployeeType $employeeType): bool
    {
        return $authUser->can('Delete:EmployeeType');
    }

    public function restore(AuthUser $authUser, EmployeeType $employeeType): bool
    {
        return $authUser->can('Restore:EmployeeType');
    }

    public function forceDelete(AuthUser $authUser, EmployeeType $employeeType): bool
    {
        return $authUser->can('ForceDelete:EmployeeType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EmployeeType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EmployeeType');
    }

    public function replicate(AuthUser $authUser, EmployeeType $employeeType): bool
    {
        return $authUser->can('Replicate:EmployeeType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EmployeeType');
    }

}