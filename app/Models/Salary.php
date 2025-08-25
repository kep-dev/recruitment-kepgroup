<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Salary extends Model
{
    use HasUuids;

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
