<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FunctionOfInterest extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable  = [
        'user_id',
        'function_of_interest'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
