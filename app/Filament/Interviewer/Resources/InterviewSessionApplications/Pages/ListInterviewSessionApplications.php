<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class ListInterviewSessionApplications extends ListRecords
{
    protected static string $resource = InterviewSessionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'scheduled' => Tab::make('Belum Diberikan Penilaian')
                ->icon(LucideIcon::Clock)
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'scheduled')),
            'in_progress' => Tab::make('Dalam Proses')
                ->icon(LucideIcon::PlayCircle)
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'in_progress'))
                ->badge(
                    fn(Builder $query) =>
                    $query->count()
                )
                ->badgeColor('warning'),
            'completed' => Tab::make('Selesai')
                ->icon(LucideIcon::CheckCircle)
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'completed')),
        ];
    }

}
