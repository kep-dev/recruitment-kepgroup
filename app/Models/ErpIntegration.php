<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ErpIntegration extends Model
{
    use HasUuids;

    protected $fillable = [
        'company_name',
        'company_code',
        'base_url',
        'bearer_token_encrypted',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Akses token secara otomatis didekripsi
    public function getBearerTokenAttribute(): string
    {
        return decrypt($this->bearer_token_encrypted);
    }

    public function setBearerTokenAttribute($value)
    {
        $this->attributes['bearer_token_encrypted'] = encrypt($value);
    }
}
