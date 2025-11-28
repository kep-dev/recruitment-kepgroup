<?php

namespace App\Models\Psychotest;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PsychotestAspect extends Model
{
    use HasUuids;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];


    public function characteristics()
    {
        return $this->hasMany(PsychotestCharacteristic::class);
    }
}
