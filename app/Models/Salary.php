<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'expected_salary',
        'current_salary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
