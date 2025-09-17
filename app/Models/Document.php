<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Document extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'vacancy_document_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacancyDocument()
    {
        return $this->belongsTo(VacancyDocument::class);
    }
}
