<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewEvaluationApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $evaluator = $this->whenLoaded('sessionEvaluator');
        $user      = $evaluator?->user;

        return [
            'evaluator' => [
                'id'   => $user?->id,
                'name' => $user?->name,
                'role' => $evaluator?->role, // lead/panel/observer
            ],

            'total_score'     => $this->total_score,
            'recommendation'  => $this->recommendation, // hire/hold/no_hire
            'overall_comment' => $this->overall_comment,
            'submitted_at'    => optional($this->submitted_at)->toIso8601String(),

            'scores' => InterviewEvaluationScoreApiResource::collection(
                $this->whenLoaded('scores') ?? collect()
            ),
        ];
    }
}
