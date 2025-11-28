<?php

namespace App\Filament\Clusters\PsychoTests;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use UnitEnum;


class PsychoTestsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BrainCircuit;
    protected static string|UnitEnum|null $navigationGroup = 'Test';
    protected static ?string $navigationLabel = 'Psikotest';
    protected static ?string $modelLabel = 'Psikotest';
    protected static ?string $pluralModelLabel = 'Psikotest';
}
