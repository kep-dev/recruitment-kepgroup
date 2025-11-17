<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
        ];
    }
}
