<?php

namespace  App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages;

use App\Models\ApplicantTest;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\JobVacancyTestResource;


class ListJobVacancyTests extends ListRecords
{
    protected static string $resource = JobVacancyTestResource::class;

    public function getTabs(): array
    {
        return [
            'Potensi Dasar Akademik' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', 'general')),
            'Psikotest' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', 'psychotest')),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
