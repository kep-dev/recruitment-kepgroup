<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Achievment extends Model
{
    use HasUuids;

    protected $fillable  = [
        'user_id',
        'achievement_name',
        'organization_name',
        'year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
