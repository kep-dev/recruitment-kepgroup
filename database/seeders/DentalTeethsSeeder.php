<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DentalTeethsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        // 📌 Mapping tooth number ke tooth type untuk gigi permanen
        $permanentToothTypes = [
            1 => 'central_incisor',
            2 => 'lateral_incisor',
            3 => 'canine',
            4 => 'first_premolar',
            5 => 'second_premolar',
            6 => 'first_molar',
            7 => 'second_molar',
            8 => 'third_molar',
        ];

        $permanentNames = [
            1 => 'UR', // Upper Right
            2 => 'UL', // Upper Left
            3 => 'LL', // Lower Left
            4 => 'LR', // Lower Right
        ];

        // 🦷 Gigi permanen (dewasa)
        foreach (range(1, 4) as $quadrant) {
            foreach (range(1, 8) as $tooth) {
                $fdi = (int)($quadrant . $tooth);
                $data[] = [
                    'fdi_code'     => $fdi,
                    'quadrant'     => $quadrant,
                    'tooth_number' => $tooth,
                    'dentition'    => 'permanent',
                    'name'         => $permanentNames[$quadrant] . $tooth,
                    'tooth_type'   => $permanentToothTypes[$tooth],
                ];
            }
        }

        // 📌 Mapping tooth number ke tooth type untuk gigi susu
        $primaryToothTypes = [
            1 => 'central_incisor',
            2 => 'lateral_incisor',
            3 => 'canine',
            4 => 'primary_first_molar',
            5 => 'primary_second_molar',
        ];

        $primaryNames = [
            5 => 'UR',
            6 => 'UL',
            7 => 'LL',
            8 => 'LR',
        ];

        // 🍼 Gigi susu (anak)
        foreach (range(5, 8) as $quadrant) {
            foreach (range(1, 5) as $tooth) {
                $fdi = (int)($quadrant . $tooth);
                $data[] = [
                    'fdi_code'     => $fdi,
                    'quadrant'     => $quadrant,
                    'tooth_number' => $tooth,
                    'dentition'    => 'primary',
                    'name'         => $primaryNames[$quadrant] . $tooth,
                    'tooth_type'   => $primaryToothTypes[$tooth],
                ];
            }
        }

        DB::table('dental_teeths')->insert($data);
    }
}
