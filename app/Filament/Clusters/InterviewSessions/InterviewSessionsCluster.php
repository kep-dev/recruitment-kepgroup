<?php

namespace App\Filament\Clusters\InterviewSessions;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Enums\SubNavigationPosition;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use UnitEnum;

class InterviewSessionsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::MessagesSquare;
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static string|UnitEnum|null $navigationGroup = 'Test';

    protected static ?string $navigationLabel = 'Sesi Interview';

    protected static ?string $modelLabel = 'Sesi Interview';

    protected static ?string $pluralModelLabel = 'Sesi Interview';
}
