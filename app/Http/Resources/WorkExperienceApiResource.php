<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkExperienceApiResource extends JsonResource
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
            'job_title' => $this->job_title,
            'company_name' => $this->company_name,
            'job_position' => $this->job_position,
            'industry' => $this->industry,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'currently_working' => $this->currently_working,
            'description' => $this->description,
        ];
    }
}
