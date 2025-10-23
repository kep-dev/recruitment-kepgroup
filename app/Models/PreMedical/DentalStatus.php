<?php

namespace App\Models\PreMedical;

use Illuminate\Database\Eloquent\Model;

class DentalStatus extends Model
{
    protected $fillable = [
        'code',
        'label',
        'description',
        'is_active',
    ];
}
