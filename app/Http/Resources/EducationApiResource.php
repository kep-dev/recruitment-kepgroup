<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EducationApiResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'education_level' => $this->education_level,
            'major' => $this->major,
            'university' => $this->university,
            'location' => $this->location,
            'graduation_year' => $this->graduation_year,
            'gpa' => $this->gpa,
            'certificate_number' => $this->certificate_number,
            'main_number' => $this->main_number
        ];
    }
}
