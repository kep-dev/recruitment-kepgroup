<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialMedia extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = 'social_medias';

    protected $fillable = [
        'name',
        'url',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
