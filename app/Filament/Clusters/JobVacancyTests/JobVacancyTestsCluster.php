<?php

namespace App\Filament\Clusters\JobVacancyTests;

use UnitEnum;
use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Enums\SubNavigationPosition;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class JobVacancyTestsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookOpen;
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static string|UnitEnum|null $navigationGroup = 'Test';

    protected static ?string $navigationLabel = 'Test Rekrutment';

    protected static ?string $modelLabel = 'Test Rekrutment';

    protected static ?string $pluralModelLabel = 'Test Rekrutment';
}
