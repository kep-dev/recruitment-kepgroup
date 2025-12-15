<?php

namespace App\Http\Controllers;

use App\Models\Psychotest\PsychotestAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PsychotestAttemptPdfController extends Controller
{
    public function download(PsychotestAttempt $attempt)
    {
        $pdf = Pdf::loadView('psychotest.attempt_pdf', ['attempt' => $attempt])->setPaper('a4');

        $fileName = 'psychotest_attempt_' . $attempt->id . '.pdf';

        return $pdf->download($fileName);
    }
}
