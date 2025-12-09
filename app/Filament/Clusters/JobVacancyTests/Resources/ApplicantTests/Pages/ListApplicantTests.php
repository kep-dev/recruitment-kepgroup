<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\ApplicantTestResource;

class ListApplicantTests extends ListRecords
{
    protected static string $resource = ApplicantTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Potensi Dasar Akademik' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereRelation('jobVacancyTest', 'type', 'general')),
            'Psikotest' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereRelation('jobVacancyTest', 'type', 'psychotest')),
        ];
    }
}
