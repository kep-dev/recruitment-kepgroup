<?php

namespace App\Filament\Resources\ErpIntegrations\Pages;

use App\Filament\Resources\ErpIntegrations\ErpIntegrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageErpIntegrations extends ManageRecords
{
    protected static string $resource = ErpIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
