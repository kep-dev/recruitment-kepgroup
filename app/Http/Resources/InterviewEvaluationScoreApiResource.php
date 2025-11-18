<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewEvaluationScoreApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'criteria_id'   => $this->interview_criteria_id,
            'criteria_name' => optional($this->criteria)->label, // relasi: criteria

            'scale_id'      => $this->interview_scale_id,
            // kalau mau pakai relasi scaleOption:
            'scale_label'   => $this->scale_label_snapshot ?? optional($this->scaleOption)->label,
            'scale_value'   => $this->scale_value_snapshot ?? optional($this->scaleOption)->value,

            'score_numeric' => $this->score_numeric,
            'comment'       => $this->comment,
        ];
    }
}
