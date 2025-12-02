<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PsychotestAspectResultApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $aspect = $this->whenLoaded('aspect');

        return [
            'aspect_id'      => $this->aspect_id,
            'aspect_code'    => $aspect?->code,
            'aspect_name'    => $aspect?->name,
            'aspect_order'   => $aspect?->order,

            'raw_score'      => $this->raw_score,
            'scaled_score'   => $this->scaled_score,
        ];
    }
}
