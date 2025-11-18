<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewSessionApplicationApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $session = $this->whenLoaded('interviewSession');

        return [
            'session_id'       => $session?->id,
            'session_title'    => $session?->title,
            'job_vacancy_id'   => $session?->job_vacancy_id,
            'scheduled_at'     => optional($session?->scheduled_at)->toIso8601String(),
            'scheduled_end_at' => optional($session?->scheduled_end_at)->toIso8601String(),

            // override per kandidat (fallback default session)
            'mode'         => $this->mode ?? $session?->default_mode,
            'location'     => $this->location ?? $session?->default_location,
            'meeting_link' => $this->meeting_link ?? $session?->default_meeting_link,

            // status & agregat per kandidat
            'status'         => $this->status,
            'avg_score'      => $this->avg_score,
            'recommendation' => $this->recommendation,

            'evaluations' => InterviewEvaluationApiResource::collection(
                $this->whenLoaded('evaluations') ?? collect()
            ),
        ];
    }
}
