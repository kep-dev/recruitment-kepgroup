<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Model;

class PreMedicalExamSection extends Model
{
    protected $fillable = [
        'code',
        'name',
        'order',
        'type'
    ];

    public function subSections()
    {
        return $this->hasMany(PreMedicalExamSubSection::class, 'section_id');
    }
}
