<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Model;

class DentalTeeth extends Model
{
    protected $fillable = [
        'fdi_code',
        'quadrant',
        'tooth_number',
        'dentition',
        'name',
        'tooth_type',
    ];
}
