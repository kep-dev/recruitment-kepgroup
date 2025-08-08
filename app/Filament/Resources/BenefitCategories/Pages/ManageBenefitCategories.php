<?php

namespace App\Filament\Resources\BenefitCategories\Pages;

use App\Filament\Resources\BenefitCategories\BenefitCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBenefitCategories extends ManageRecords
{
    protected static string $resource = BenefitCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
