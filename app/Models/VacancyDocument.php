<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacancyDocument extends Model
{
    protected $fillable = [
        'name',
        'is_required',
        'is_active'
    ];
}
