<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Psychotest\PsychotestCharacteristicScore;

class PsychotestCharacteristicResultApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $characteristic = $this->whenLoaded('characteristic');
        $aspect         = $characteristic?->psychotestAspect;

        // Cari deskripsi interpretasi skor (0–9) untuk karakteristik ini
        $scoreRow = PsychotestCharacteristicScore::query()
            ->where('characteristic_id', $this->characteristic_id)
            ->where('score', $this->scaled_score)
            ->first();

        return [
            'characteristic_id'   => $this->characteristic_id,
            'characteristic_code' => $characteristic?->code,
            'characteristic_name' => $characteristic?->name,

            'aspect_id'           => $aspect?->id,
            'aspect_code'         => $aspect?->code,
            'aspect_name'         => $aspect?->name,

            'raw_score'           => $this->raw_score,
            'scaled_score'        => $this->scaled_score,

            // Interpretasi skor skala 0–9 (dari tabel psychotest_characteristic_scores)
            'score_interpretation'    => $scoreRow?->description,

            // Deskripsi umum karakteristik
            'characteristic_description' => $characteristic?->description,
        ];
    }
}
