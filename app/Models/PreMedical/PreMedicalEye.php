<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PreMedicalEye extends Model
{
    use HasUuids;

    protected $fillable = [
        'pre_medical_result_id',
        'va_unaided_right',
        'va_unaided_left',
        'va_aided_right',
        'va_aided_left',
        'color_vision',
        'conjunctiva',
        'sclera',
        'others',
    ];

    public function preMedicalResult()
    {
        return $this->belongsTo(PreMedicalResult::class);
    }
}
