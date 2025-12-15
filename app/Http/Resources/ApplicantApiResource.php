<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\EducationApiResource;
use App\Http\Resources\DocumentApiResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApplicantApiResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user?->name,
            'email' => $this->user?->email,
            'nik' => $this->nik,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'photo' => $this->photo,
            'address_line' => collect([
                $this->province?->name,
                $this->district?->name,
                $this->regency?->name,
                $this->village?->name,
                $this->address_line,
            ])
                ->filter()      // hilangkan null
                ->join(', '),
            'postal_code' => $this->postal_code,
            'educations' => EducationApiResource::collection(
                $this->user?->educations ?? collect()
            ),
            'work_experiences' => WorkExperienceApiResource::collection(
                $this->user?->workExperiences ?? collect()
            ),

            'organizational_experiences' => OrganizationalExperienceApiResource::collection(
                $this->user?->organizationalExperiences ?? collect()
            ),

            'training_certifications' => TrainingCertificationApiResource::collection(
                $this->user?->trainingCertifications ?? collect()
            ),

            'achievements' => AchievementApiResource::collection(
                $this->user?->achievements ?? collect()
            ),
            'documents' => DocumentApiResource::collection(
                $this->user->documents ?? collect()
            ),
        ];
    }
}
