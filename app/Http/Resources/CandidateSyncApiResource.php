<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateSyncApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // applicant (sudah kamu punya)
        $applicant = $this->user?->applicant;

        // kumpulkan attempts untuk test_results
        $attempts = collect();
        if ($this->relationLoaded('applicantTests')) {
            $attempts = $this->applicantTests->attempts->map(function ($attempt) {
                return [
                    'id' => $attempt->id,
                    'score' => $attempt->score,
                    'test_name' => $attempt->jobVacancyTestItem->test->title,
                    'number_of_questions' => $attempt->jobVacancyTestItem->number_of_question,
                    'multiplier' => $attempt->jobVacancyTestItem->multiplier,
                    'minimum_score' => $attempt->jobVacancyTestItem->minimum_score,

                    'correct_answers' => $attempt->answers->where('is_correct', true)->count(),
                    'wrong_answers' => $attempt->answers->where('is_correct', false)->count(),
                    'skipped_questions' => $attempt->answers->whereNull('selected_choice_id')->count(),
                ];
            });
        }

        // interview session applications
        $sessionApplications = $this->relationLoaded('interviewSessionApplications')
            ? $this->interviewSessionApplications
            : collect();

        $psychotestAttempt = $this->applicantPsychotest?->psychotestAttempts()
            ->with([
                'form',
                'aspects.aspect',
                'characteristics.characteristic.psychotestAspect',
            ])
            ->latest('completed_at')
            ->first();

        return [
            'applicant' => ApplicantApiResource::make($applicant),

            'test_results' => TestResultApiResource::collection($attempts),

            'interview_results' => InterviewSessionApplicationApiResource::collection($sessionApplications),

            'psychotest_result' => $psychotestAttempt
                ? PsychotestResultApiResource::make($psychotestAttempt)
                : null,
        ];
    }
}
