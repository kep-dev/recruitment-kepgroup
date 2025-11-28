<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages;

use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Psychotest\PsychotestAspect;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\PsychotestAspectResource;

class CreatePsychotestAspect extends CreateRecord
{
    protected static string $resource = PsychotestAspectResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $aspect = static::getModel()::create([
            'name'        => $data['name'],
            'code'        => $data['code'],
            'description' => $data['description'] ?? null,
        ]);

        $characteristics = $data['characteristics'] ?? [];

        foreach ($characteristics as $characteristic) {
            if (empty($characteristic['name']) || empty($characteristic['code'])) {
                continue;
            }

            $psychotestCharacteristic = $aspect->characteristics()->create([
                'name'        => $characteristic['name'],
                'code'        => $characteristic['code'],
                'description' => $characteristic['description'] ?? null,
                'order'       => $characteristic['order'] ?? 0,
            ]);

            $scores = $characteristic['scores'] ?? [];

            foreach ($scores as $score) {
                if (! array_key_exists('score', $score) || $score['score'] === null) {
                    continue;
                }

                $psychotestCharacteristic->psychotestCharacteristicScores()->create([
                    'score'       => $score['score'],
                    'description' => $score['description'] ?? '',
                ]);
            }
        }

        return $aspect;
    }
}
