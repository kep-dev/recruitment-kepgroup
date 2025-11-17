<?php

namespace App\Filament\Resources\JobVacancyTests\Pages;

use App\Models\ApplicantTest;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;

class ListJobVacancyTests extends ListRecords
{
    protected static string $resource = JobVacancyTestResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Test Karyawan'),
            'active' => Tab::make('Karyawan Yang Telah Melalui Tes')
                ->modifyQueryUsing(function ($query) {
                    return ApplicantTest::query()
                        ->whereNotNull('total_score');
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
