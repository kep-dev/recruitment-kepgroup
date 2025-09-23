<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BenefitCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class BenefitCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BenefitCategory');
    }

    public function view(AuthUser $authUser, BenefitCategory $benefitCategory): bool
    {
        return $authUser->can('View:BenefitCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BenefitCategory');
    }

    public function update(AuthUser $authUser, BenefitCategory $benefitCategory): bool
    {
        return $authUser->can('Update:BenefitCategory');
    }

    public function delete(AuthUser $authUser, BenefitCategory $benefitCategory): bool
    {
        return $authUser->can('Delete:BenefitCategory');
    }

    public function restore(AuthUser $authUser, BenefitCategory $benefitCategory): bool
    {
        return $authUser->can('Restore:BenefitCategory');
    }

    public function forceDelete(AuthUser $authUser, BenefitCategory $benefitCategory): bool
    {
        return $authUser->can('ForceDelete:BenefitCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BenefitCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BenefitCategory');
    }

    public function replicate(AuthUser $authUser, BenefitCategory $benefitCategory): bool
    {
        return $authUser->can('Replicate:BenefitCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BenefitCategory');
    }

}