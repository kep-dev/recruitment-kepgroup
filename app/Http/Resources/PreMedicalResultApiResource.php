<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PreMedical\PreMedicalExamSection;

class PreMedicalResultApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $pre = $this->resource;

        if (! $pre) {
            return null;
        }

        $preMedicalPhysical = $pre->preMedicalPhysical;

        $types = ['physic', 'ent', 'eye'];

        $sections = [];

        foreach ($types as $type) {
            $secs = PreMedicalExamSection::with(['subSections.items.itemChecks' => function ($q) use ($preMedicalPhysical) {
                if ($preMedicalPhysical) {
                    $q->where('checkable_id', $preMedicalPhysical->id)
                        ->where('checkable_type', get_class($preMedicalPhysical));
                } else {
                    $q->whereNull('id');
                }
            }])
                ->where('type', $type)
                ->orderBy('order')
                ->get()
                ->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'name' => $section->name,
                        'sub_sections' => $section->subSections->map(function ($sub) {
                            return [
                                'id' => $sub->id,
                                'name' => $sub->name,
                                'items' => $sub->items->map(function ($item) {
                                    $check = $item->itemChecks->first();

                                    return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                        'value' => $check?->value,
                                        'note' => $check?->note,
                                    ];
                                })->toArray(),
                            ];
                        })->toArray(),
                    ];
                })->toArray();

            $sections[$type] = $secs;
        }

        return [
            'id' => $pre->id,
            'examined_at' => $pre->examined_at,
            'overall_status' => $pre->overall_status,
            'overall_note' => $pre->overall_note,
            'history' => $pre->preMedicalHistory?->toArray(),
            'physical' => $preMedicalPhysical?->toArray(),
            'eye' => $pre->preMedicalEye?->toArray(),
            'ent' => $pre->preMedicalEnt?->toArray(),
            'dental' => $pre->preMedicalDental?->toArray(),
            'obgyn' => $pre->preMedicalObgyn?->toArray(),
            'supporting_examination' => $pre->preMedicalSupportingExamination?->toArray(),
            'sections' => $sections,
        ];
    }
}
