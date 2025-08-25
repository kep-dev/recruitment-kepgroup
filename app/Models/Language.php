<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasUuids;

    protected $fillable  = [
        'user_id',
        'language',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
