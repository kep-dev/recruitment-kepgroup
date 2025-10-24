<?php

namespace App\Observers;

use App\Models\PreMedical\PreMedicalResult;
use Illuminate\Support\Facades\DB;

class PreMedicalResultObserver
{
    public function saved(PreMedicalResult $result)
    {
        if (! $result->pre_medical_session_application_id) {
            return;
        }

        DB::table('pre_medical_session_applications')
            ->where('id', $result->pre_medical_session_application_id)
            ->update([
                'status' => 'completed',
                'result_status' => $result->overall_status,   // 'pending' | 'fit' | 'fit_with_notes' | 'unfit'
                'result_note'   => $result->overall_note,     // opsional, kalau mau ikut disinkron
                'reviewed_by'   => $result->examined_by,      // opsional
                'reviewed_at'   => $result->examined_at,      // opsional
                'updated_at'    => now(),
            ]);
    }

    public function deleted(PreMedicalResult $result): void
    {
        if (! $result->pre_medical_session_application_id) {
            return;
        }

        DB::table('pre_medical_session_applications')
            ->where('id', $result->pre_medical_session_application_id)
            ->update([
                'status'        => 'scheduled',
                'result_status' => 'pending',
                'result_note'   => null,
                'reviewed_by'   => null,
                'reviewed_at'   => null,
                'updated_at'    => now(),
            ]);
    }
}
