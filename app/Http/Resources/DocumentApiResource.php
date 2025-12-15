<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        // ...existing code...

        $collectionName = optional($this->vacancyDocument)->name;

        return [
            'name' => $collectionName,          // semua file untuk record ini
            'url' => $this->getFirstMediaUrl($collectionName), // jika butuh hanya 1 url
        ];
    }
}
