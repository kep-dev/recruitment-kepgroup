<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestForm extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
    ];

    public function questions()
    {
        return $this->hasMany(PsychotestQuestion::class, 'psychotest_form_id');
    }
}
