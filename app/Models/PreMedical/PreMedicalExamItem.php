<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Model;

class PreMedicalExamItem extends Model
{
    protected $fillable = [
        'subsection_id',
        'code',
        'name',
        'value_type',
        'order',
    ];

    public function subSection()
    {
        return $this->belongsTo(PreMedicalExamSubSection::class, 'subsection_id');
    }

    public function itemChecks()
    {
        return $this->hasMany(PreMedicalItemCheck::class, 'pre_medical_exam_item_id', 'id');
    }
}
