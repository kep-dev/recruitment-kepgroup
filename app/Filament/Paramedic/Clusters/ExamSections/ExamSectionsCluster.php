<?php

namespace App\Filament\Paramedic\Clusters\ExamSections;

use UnitEnum;
use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Enums\SubNavigationPosition;

class ExamSectionsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Master Input';

    protected static ?string $modelLabel = 'Master Input';

    protected static ?string $pluralModelLabel = 'Master Input';
}
