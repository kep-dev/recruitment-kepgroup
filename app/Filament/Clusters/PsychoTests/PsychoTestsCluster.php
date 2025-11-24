<?php

namespace App\Filament\Clusters\PsychoTests;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;


class PsychoTestsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BrainCircuit;
}
