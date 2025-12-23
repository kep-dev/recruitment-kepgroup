<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalItemCheck extends Model
{
    use HasUuids;

    protected $fillable = [
        'checkable_type',
        'checkable_id',
        'pre_medical_exam_item_id',
        'value',
        'note',
    ];

    public function preMedicalExamItem()
    {
        return $this->belongsTo(PreMedicalExamItem::class, 'pre_medical_exam_item_id');
    }
}
