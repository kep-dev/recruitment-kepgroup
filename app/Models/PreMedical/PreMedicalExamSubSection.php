<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Model;

class PreMedicalExamSubSection extends Model
{
    protected $fillable = [
        'section_id',
        'code',
        'name',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(PreMedicalExamSection::class, 'section_id');
    }

    public function items()
    {
        return $this->hasMany(PreMedicalExamItem::class, 'subsection_id');
    }
}
