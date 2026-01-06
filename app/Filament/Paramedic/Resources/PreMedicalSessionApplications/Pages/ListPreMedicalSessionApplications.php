<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Widgets\SelectPreMedicalWidget;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\PreMedicalSessionApplicationResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class ListPreMedicalSessionApplications extends ListRecords
{
    protected static string $resource = PreMedicalSessionApplicationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            // SelectPreMedicalWidget::class,
            //
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'notyet' => Tab::make('Belum Dilakukan Pemeriksaan')
                ->icon(LucideIcon::Hourglass)
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('reviewed_at')),
            'done' => Tab::make('Sudah Dilakukan Pemeriksaan')
                ->icon(LucideIcon::CheckCircle2)
                ->modifyQueryUsing(fn(Builder $query) =>
                $query->whereNotNull('reviewed_at')),

        ];
    }
}
