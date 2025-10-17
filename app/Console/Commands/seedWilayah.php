<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class seedWilayah extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wilayah:import {--concurrency=20} {--chunk=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk wilayah indonesia';
    private string $base = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $concurrency = (int) $this->option('concurrency');
        $chunk       = (int) $this->option('chunk');
        $now         = Carbon::now();

        $this->info('=== Import Wilayah Indonesia (Batch Upsert per Level) ===');

        // ======================
        // 1) PROVINCES (ALL)
        // ======================
        $this->newLine();
        $this->info('1) Mengambil semua PROVINSI...');
        $provinces = Http::get("{$this->base}/provinces.json")->json() ?? [];
        $provRows = collect($provinces)->map(fn($p) => [
            'code'       => (string) $p['id'],
            'name'       => $p['name'],
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        $this->batchUpsert(Province::class, $provRows, ['code'], ['name', 'updated_at'], $chunk);
        $this->info("✔️ Provinces upserted: " . count($provRows));

        // ======================
        // 2) REGENCIES (ALL via pool per province)
        // ======================
        $this->newLine();
        $this->info('2) Mengambil semua KAB/KOTA (paralel per provinsi)...');
        $provCodes = array_column($provRows, 'code');

        $regRows = $this->poolFetchAndFlatten(
            $provCodes,
            fn($provCode) => "{$this->base}/regencies/{$provCode}.json",
            function ($items, $provCode) use ($now) {
                return collect($items)->map(fn($r) => [
                    'code'          => (string) $r['id'],
                    'name'          => $r['name'],
                    'province_code' => (string) $provCode,
                    'created_at'    => $now,
                    'updated_at' => $now,
                ])->all();
            },
            $concurrency,
            label: 'regencies'
        );

        $this->batchUpsert(Regency::class, $regRows, ['code'], ['name', 'province_code', 'updated_at'], $chunk);
        $this->info("✔️ Regencies upserted: " . count($regRows));

        // ======================
        // 3) DISTRICTS (ALL via pool per regency)
        // ======================
        $this->newLine();
        $this->info('3) Mengambil semua KECAMATAN (paralel per kab/kota)...');
        $regCodes = array_column($regRows, 'code');

        $distRows = $this->poolFetchAndFlatten(
            $regCodes,
            fn($regCode) => "{$this->base}/districts/{$regCode}.json",
            function ($items, $regCode) use ($now) {
                return collect($items)->map(fn($d) => [
                    'code'         => (string) $d['id'],
                    'name'         => $d['name'],
                    'regency_code' => (string) $regCode,
                    'created_at'   => $now,
                    'updated_at' => $now,
                ])->all();
            },
            $concurrency,
            label: 'districts'
        );

        $this->batchUpsert(District::class, $distRows, ['code'], ['name', 'regency_code', 'updated_at'], $chunk);
        $this->info("✔️ Districts upserted: " . count($distRows));

        // ======================
        // 4) VILLAGES (ALL via pool per district)
        // ======================
        $this->newLine();
        $this->info('4) Mengambil semua DESA/KELURAHAN (paralel per kecamatan)...');
        $distCodes = array_column($distRows, 'code');

        $vilRows = $this->poolFetchAndFlatten(
            $distCodes,
            fn($distCode) => "{$this->base}/villages/{$distCode}.json",
            function ($items, $distCode) use ($now) {
                return collect($items)->map(fn($v) => [
                    'code'          => (string) $v['id'],
                    'name'          => $v['name'],
                    'district_code' => (string) $distCode,
                    'created_at'    => $now,
                    'updated_at' => $now,
                ])->all();
            },
            $concurrency,
            label: 'villages'
        );

        $this->batchUpsert(Village::class, $vilRows, ['code'], ['name', 'district_code', 'updated_at'], $chunk);
        $this->info("✔️ Villages upserted: " . count($vilRows));

        $this->newLine();
        $this->info('✅ Selesai. Semua level di-upsert dengan batch.');
        return self::SUCCESS;
    }

    private function poolFetchAndFlatten(array $keys, callable $makeUrl, callable $transform, int $concurrency, string $label)
    {
        $bar = $this->output->createProgressBar(count($keys));
        $bar->setFormat(" %current%/%max% [%bar%] %percent:3s%% | {$label}");
        $bar->start();

        $rows = [];
        // Chunk keys to respect concurrency
        foreach (array_chunk($keys, $concurrency) as $chunkKeys) {
            $responses = Http::pool(function ($pool) use ($chunkKeys, $makeUrl) {
                foreach ($chunkKeys as $k) {
                    $pool->as((string) $k)->get($makeUrl($k));
                }
            });

            foreach ($chunkKeys as $k) {
                $resp = $responses[(string) $k] ?? null;
                $json = $resp && $resp->successful() ? $resp->json() : [];
                // Transform to rows and merge
                $rows = array_merge($rows, $transform($json, $k));
                $bar->advance();
            }
        }
        $bar->finish();
        $this->newLine(2);
        return $rows;
    }

    /**
     * Upsert in chunks to reduce memory & statement size.
     */
    private function batchUpsert(string $modelClass, array $rows, array $uniqueBy, array $update, int $chunk = 1000): void
    {
        foreach (array_chunk($rows, $chunk) as $part) {
            $modelClass::upsert($part, $uniqueBy, $update);
        }
    }
}
