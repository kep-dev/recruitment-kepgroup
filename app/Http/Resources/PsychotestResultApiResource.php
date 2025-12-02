<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PsychotestResultApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $form = $this->whenLoaded('form');

        return [
            'attempt_id'  => $this->id,
            'status'      => $this->status,
            'attempt_no'  => $this->attempt_no,
            'score'       => $this->score,
            'started_at'  => optional($this->started_at)->toIso8601String(),
            'completed_at' => optional($this->completed_at)->toIso8601String(),
            'deadline_at' => optional($this->deadline_at)->toIso8601String(),

            'form' => [
                'id'   => $form?->id,
                'name' => $form?->name,
            ],

            // skor per aspek
            'aspects' => PsychotestAspectResultApiResource::collection(
                $this->whenLoaded('aspects') ?? collect()
            ),

            // skor per karakteristik
            'characteristics' => PsychotestCharacteristicResultApiResource::collection(
                $this->whenLoaded('characteristics') ?? collect()
            ),
        ];
    }
}
