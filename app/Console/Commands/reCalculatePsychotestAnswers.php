<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PsychotestScoringService;
use App\Models\Psychotest\PsychotestAttempt;

class reCalculatePsychotestAnswers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:re-calculate-psychotest-answers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate psychotest results (aspects & characteristics) from stored answers.';

    public function __construct(
        protected PsychotestScoringService $scoringService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perhitungan ulang hasil psikotest...');

        // Ambil semua attempt yang punya jawaban
        $query = PsychotestAttempt::query()
            ->whereHas('answers');

        $count = $query->count();

        if ($count === 0) {
            $this->warn('Tidak ada attempt yang memiliki jawaban.');
            // return SymfonyCommand::SUCCESS;
        }

        $this->info("Menemukan {$count} attempt dengan jawaban. Memproses...");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $processed = 0;

        $query->chunkById(100, function ($attempts) use (&$processed, $bar) {
            foreach ($attempts as $attempt) {
                // Service ini akan menghitung ulang dan mengisi:
                // - psychotest_result_aspects
                // - psychotest_result_characteristics
                $this->scoringService->calculate($attempt);

                $processed++;
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);
        $this->info("Selesai. Berhasil menghitung ulang {$processed} attempt psikotest.");

        // return SymfonyCommand::SUCCESS;
    }
}
