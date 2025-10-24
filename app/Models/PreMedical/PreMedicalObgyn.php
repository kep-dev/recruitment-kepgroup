<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalObgyn extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'is_pregnant',
        'lmp_date',
        'gravida',
        'para',
        'abortus',
        'uterus_exam',
        'adnexa_exam',
        'cervix_exam',
        'others',
    ];

    public function preMedicalResult()
    {
        return $this->belongsTo(PreMedicalResult::class);
    }

    protected function casts() : array
    {
        return [
            'is_pregnant' => 'boolean',
        ];
    }

}
