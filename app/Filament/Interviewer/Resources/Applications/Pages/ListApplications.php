<?php

namespace App\Filament\Interviewer\Resources\Applications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Interviewer\Resources\Applications\ApplicationResource;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Pelamar'),
            'testAttempts' => Tab::make('Pelamar yang sudah melalui test potensi akademik / psikotest')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where(function ($q) {
                        $q
                            ->whereHas('applicantTests.attempts')
                            ->whereHas('applicantTests.psychotestAttempts');
                    })
                ),
            'interview' => Tab::make('Pelamar yang sudah melalui interview')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('interviewSessionApplications')),
        ];
    }
}
