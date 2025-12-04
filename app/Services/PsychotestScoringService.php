<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use App\Models\Psychotest\PsychotestAnswer;
use App\Models\Psychotest\PsychotestAttempt;
use App\Models\Psychotest\PsychotestResultAspect;
use App\Models\Psychotest\PsychotestCharacteristic;
use App\Models\Psychotest\PsychotestResultCharacteristic;

class PsychotestScoringService
{
    /**
     * Hitung dan simpan skor psikotest untuk 1 attempt.
     *
     * @param  \App\Models\PsychotestAttempt|int|string  $attempt
     */
    public function calculate($attempt): void
    {
        // Pastikan kita punya instance PsychotestAttempt
        if (! $attempt instanceof PsychotestAttempt) {
            $attempt = PsychotestAttempt::with('form')->findOrFail($attempt);
        }

        DB::transaction(function () use ($attempt) {
            $this->recalculateForAttempt($attempt);
        });
    }

    /**
     * Logika utama perhitungan skor psikotest.
     */
    protected function recalculateForAttempt(PsychotestAttempt $attempt): void
    {
        // 1. Ambil semua jawaban + option + mapping karakteristik
        $answers = PsychotestAnswer::query()
            ->where('attempt_id', $attempt->id)
            ->with([
                'option.mappings', // pastikan model PsychotestAnswer punya relasi `option`
            ])
            ->get();

        if ($answers->isEmpty()) {
            // Tidak ada jawaban, hapus hasil sebelumnya saja
            PsychotestResultCharacteristic::where('attempt_id', $attempt->id)->delete();
            PsychotestResultAspect::where('attempt_id', $attempt->id)->delete();
            return;
        }

        // 2. Hitung skor mentah per karakteristik (raw_score)
        $rawByCharacteristic = [];

        foreach ($answers as $answer) {
            $option = $answer->option;

            if (! $option) {
                continue;
            }

            foreach ($option->mappings as $mapping) {
                $charId = $mapping->characteristic_id;
                $weight = $mapping->weight ?? 1;

                if (! isset($rawByCharacteristic[$charId])) {
                    $rawByCharacteristic[$charId] = 0;
                }

                $rawByCharacteristic[$charId] += $weight;
            }
        }

        if (empty($rawByCharacteristic)) {
            // Tidak ada kontribusi mapping ke karakteristik
            PsychotestResultCharacteristic::where('attempt_id', $attempt->id)->delete();
            PsychotestResultAspect::where('attempt_id', $attempt->id)->delete();
            return;
        }

        // 3. Hitung skor maksimal per karakteristik
        //    Berdasarkan seluruh mapping di form ini (bukan hanya jawaban yang dipilih)
        $characteristicIds = array_keys($rawByCharacteristic);
        // dd($attempt);
        $maxRows = DB::table('psychotest_option_characteristic_mappings as m')
            ->join('psychotest_question_options as o', 'm.option_id', '=', 'o.id')
            ->join('psychotest_questions as q', 'o.psychotest_question_id', '=', 'q.id')
            ->where('q.psychotest_form_id', $attempt->form_id)
            ->whereIn('m.characteristic_id', $characteristicIds)
            ->select(
                'm.characteristic_id',
                DB::raw('SUM(m.weight) as max_raw_score')
            )
            ->groupBy('m.characteristic_id')
            ->get();

        $maxByCharacteristic = [];

        foreach ($maxRows as $row) {
            $maxByCharacteristic[$row->characteristic_id] = (int) $row->max_raw_score;
        }


        // 4. Ambil data karakteristik + aspek untuk agregasi aspek nanti
        $characteristics = PsychotestCharacteristic::query()
            ->with('psychotestAspect')
            ->whereIn('id', $characteristicIds)
            ->get()
            ->keyBy('id');


        // 5. Bersihkan hasil lama
        PsychotestResultCharacteristic::where('attempt_id', $attempt->id)->delete();
        PsychotestResultAspect::where('attempt_id', $attempt->id)->delete();

        // 6. Simpan hasil per karakteristik
        $aspectRaw       = []; // [aspect_id => total_raw]
        $aspectCharCount = []; // [aspect_id => jumlah karakteristik yang punya hasil]

        foreach ($rawByCharacteristic as $charId => $rawScore) {
            /** @var \App\Models\PsychotestCharacteristic|null $char */
            $char = $characteristics->get($charId);

            if (! $char) {
                continue;
            }

            $maxRaw = $maxByCharacteristic[$charId] ?? 0;
            $scaled = $this->scaleScore($rawScore, $maxRaw); // ini tetap 0–9 per karakteristik

            // Simpan result per karakteristik
            PsychotestResultCharacteristic::create([
                'attempt_id'        => $attempt->id,
                'characteristic_id' => $charId,
                'raw_score'         => $rawScore,
                'scaled_score'      => $scaled,
            ]);
            // dd($char);
            // Kumpulkan untuk agregasi aspek
            $aspectId = $char->psychotest_aspect_id;

            if (! $aspectId) {
                continue;
            }

            if (! isset($aspectRaw[$aspectId])) {
                $aspectRaw[$aspectId]       = 0;
                $aspectCharCount[$aspectId] = 0;
            }

            $aspectRaw[$aspectId]       += $rawScore;
            $aspectCharCount[$aspectId] += 1;
        }
        // dd($aspectRaw);
        // 7. Simpan hasil per aspek
        foreach ($aspectRaw as $aspectId => $rawScore) {
            if (! $aspectId) {
                continue; // safety extra
            }

            $charCount = $aspectCharCount[$aspectId] ?? 0;

            if ($charCount <= 0) {
                // kalau entah kenapa tidak ada karakteristik yg tercatat, anggap 0
                $avgRaw = 0;
            } else {
                // rata-rata raw per karakteristik
                $avgRaw = $rawScore / $charCount;
            }

            // scaled_score aspek = rata-rata raw per karakteristik, dibulatkan & dibatasi 0–9
            $scaled = $avgRaw;

            if ($scaled < 0) {
                $scaled = 0;
            } elseif ($scaled > 9) {
                $scaled = 9;
            }

            PsychotestResultAspect::create([
                'attempt_id'   => $attempt->id,
                'aspect_id'    => $aspectId,
                'raw_score'    => $rawScore,  // total raw semua karakteristik di aspek tsb
                'scaled_score' => $scaled,    // hasil rata-rata (0–9)
            ]);
        }
    }

    /**
     * Konversi skor mentah ke skala 0–9.
     */
    protected function scaleScore($rawScore, $maxRawScore)
    {
        if ($rawScore <= 0 || $maxRawScore <= 0) {
            return 0;
        }

        $scaled = round(($rawScore / $maxRawScore) * 9);

        // Clamp antara 0 dan 9
        if ($scaled < 0) {
            $scaled = 0;
        } elseif ($scaled > 9) {
            $scaled = 9;
        }

        return $scaled;
    }
}
