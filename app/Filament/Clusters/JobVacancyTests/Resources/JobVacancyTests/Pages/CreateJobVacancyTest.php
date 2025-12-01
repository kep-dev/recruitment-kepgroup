<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages;


use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\JobVacancyTestResource;

class CreateJobVacancyTest extends CreateRecord
{
    protected static string $resource = JobVacancyTestResource::class;
}
