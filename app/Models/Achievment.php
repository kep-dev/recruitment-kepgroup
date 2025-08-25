<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Achievment extends Model
{
    use HasUuids;

    protected $fillable  = [
        'user_id',
        'achievment_name',
        'organization_name',
        'year',
    ];
}
