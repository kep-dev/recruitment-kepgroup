<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\FunctionOfInterest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\ApplicationSnapshot\ApplicationProfileSnapshot;

class ApplicationFunctionOfInterestSnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_function_of_interest_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'function_of_interest',
        'function_of_interest_id',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceFunctionOfInterest()
    {
        return $this->belongsTo(FunctionOfInterest::class, 'function_of_interest_id');
    }
}
