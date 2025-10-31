<?php

namespace App\Models\ApplicationSnapshot;

use App\Models\Salary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApplicationSalarySnapshot extends Model
{
    use HasUuids;

    protected $table = 'application_salary_snapshots';

    protected $fillable = [
        'application_snapshot_id',
        'expected_salary',
        'current_salary',
        'currency',
        'salary_id',
    ];

    protected $casts = [
        'expected_salary' => 'decimal:2',
        'current_salary'  => 'decimal:2',
    ];

    public function snapshot()
    {
        return $this->belongsTo(ApplicationProfileSnapshot::class, 'application_snapshot_id');
    }

    public function sourceSalary()
    {
        return $this->belongsTo(Salary::class, 'salary_id');
    }
}
