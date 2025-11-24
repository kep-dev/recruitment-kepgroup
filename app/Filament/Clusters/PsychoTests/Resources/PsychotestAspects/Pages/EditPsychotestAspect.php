<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\PsychotestAspectResource;

class EditPsychotestAspect extends EditRecord
{
    protected static string $resource = PsychotestAspectResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $aspect = $this->record->load('characteristics.psychotestCharacteristicScores');

        $data['code']        = $aspect->code;
        $data['name']        = $aspect->name;
        $data['description'] = $aspect->description;

        $data['characteristics'] = $aspect->characteristics
            ->map(function ($characteristic) {
                return [
                    'code'        => $characteristic->code,
                    'name'        => $characteristic->name,
                    'order'       => $characteristic->order,
                    'description' => $characteristic->description,
                    'scores'      => $characteristic->psychotestCharacteristicScores
                        ->sortBy('score') // opsional, biar rapi 0–9
                        ->map(function ($score) {
                            return [
                                'score'       => $score->score,
                                'description' => $score->description,
                            ];
                        })
                        ->values()
                        ->toArray(),
                ];
            })
            ->values()
            ->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update aspek
        $record->update([
            'name'        => $data['name'],
            'code'        => $data['code'],
            'description' => $data['description'] ?? null,
        ]);

        // Hapus karakteristik + skor lama (satu aspek)
        $record->characteristics()->each(function ($char) {
            $char->psychotestCharacteristicScores()->delete();
            $char->delete();
        });

        // Insert ulang dari form, sama seperti di handleRecordCreation
        $characteristics = $data['characteristics'] ?? [];

        foreach ($characteristics as $characteristic) {
            if (empty($characteristic['name']) || empty($characteristic['code'])) {
                continue;
            }

            $psychotestCharacteristic = $record->characteristics()->create([
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

        return $record;
    }


    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
