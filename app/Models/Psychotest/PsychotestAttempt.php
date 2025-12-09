<?php

namespace App\Models\Psychotest;

use App\Enums\status;
use App\Models\ApplicantTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PsychotestAttempt extends Model
{
    use HasUuids;

    protected $fillable = [
        'form_id',
        'applicant_test_id',
        'status',
        'started_at',
        'completed_at',
        'attempt_no',
        'ended_reason',
        'score',
        'deadline_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => status::class,
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function form()
    {
        return $this->belongsTo(PsychotestForm::class);
    }

    public function applicantTest()
    {
        return $this->belongsTo(ApplicantTest::class, 'applicant_test_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(PsychotestAnswer::class, 'attempt_id', 'id');
    }

    public function characteristics(): HasMany
    {
        return $this->hasMany(PsychotestResultCharacteristic::class, 'attempt_id', 'id')
            ->select('psychotest_result_characteristics.*')
            ->join('psychotest_characteristics', 'psychotest_result_characteristics.characteristic_id', '=', 'psychotest_characteristics.id')
            ->orderBy('psychotest_characteristics.order');
    }

    public function aspects()
    {
        return $this->hasMany(PsychotestResultAspect::class, 'attempt_id', 'id');
    }
}
