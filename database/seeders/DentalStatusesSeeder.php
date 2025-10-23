<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DentalStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['code' => 'D', 'label' => 'Decay',        'description' => 'Karies/berlubang'],
            ['code' => 'M', 'label' => 'Missing',      'description' => 'Gigi hilang'],
            ['code' => 'F', 'label' => 'Filled',       'description' => 'Tambalan'],
            ['code' => 'K', 'label' => 'Calculus',     'description' => 'Kalkulus'],
            ['code' => 'G', 'label' => 'Gingivitis',   'description' => 'Radang gusi'],
            ['code' => 'P', 'label' => 'Periodontal',  'description' => 'Periodontitis/Pocket'],
            ['code' => 'S', 'label' => 'Sealant',      'description' => 'Sealant'],
            ['code' => 'O', 'label' => 'Others',       'description' => 'Lainnya'],
        ];

        // upsert by code
        foreach ($rows as $r) {
            DB::table('dental_statuses')->updateOrInsert(
                ['code' => $r['code']],
                [
                    'label' => $r['label'],
                    'description' => $r['description'] ?? null,
                    'is_active' => true,
                ]
            );
        }
    }
}
