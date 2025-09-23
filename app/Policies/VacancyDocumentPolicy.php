<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\VacancyDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyDocumentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:VacancyDocument');
    }

    public function view(AuthUser $authUser, VacancyDocument $vacancyDocument): bool
    {
        return $authUser->can('View:VacancyDocument');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:VacancyDocument');
    }

    public function update(AuthUser $authUser, VacancyDocument $vacancyDocument): bool
    {
        return $authUser->can('Update:VacancyDocument');
    }

    public function delete(AuthUser $authUser, VacancyDocument $vacancyDocument): bool
    {
        return $authUser->can('Delete:VacancyDocument');
    }

    public function restore(AuthUser $authUser, VacancyDocument $vacancyDocument): bool
    {
        return $authUser->can('Restore:VacancyDocument');
    }

    public function forceDelete(AuthUser $authUser, VacancyDocument $vacancyDocument): bool
    {
        return $authUser->can('ForceDelete:VacancyDocument');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:VacancyDocument');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:VacancyDocument');
    }

    public function replicate(AuthUser $authUser, VacancyDocument $vacancyDocument): bool
    {
        return $authUser->can('Replicate:VacancyDocument');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:VacancyDocument');
    }

}