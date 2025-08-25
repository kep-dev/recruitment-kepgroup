<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Work Types (Jenis Pekerjaan: WFO, WFH, Hybrid)
        DB::table('work_types')->insert([
            [
                'name' => 'Work From Office',
                'description' => 'Bekerja penuh dari kantor.',
                'icon' => 'building', // lucide icon
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Work From Home',
                'description' => 'Bekerja penuh dari rumah.',
                'icon' => 'laptop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hybrid',
                'description' => 'Kombinasi bekerja dari kantor dan rumah.',
                'icon' => 'git-branch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Employee Types (Jenis Karyawan: Tetap, Kontrak, Intern)
        DB::table('employee_types')->insert([
            [
                'name' => 'Karyawan Tetap',
                'description' => 'Karyawan dengan status permanen.',
                'icon' => 'user-check',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karyawan Kontrak',
                'description' => 'Karyawan dengan perjanjian kerja waktu tertentu.',
                'icon' => 'user-cog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Magang / Intern',
                'description' => 'Karyawan dengan status intern atau magang.',
                'icon' => 'user-plus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Job Levels (Level Jabatan)
        DB::table('job_levels')->insert([
            [
                'name' => 'Staff',
                'description' => 'Level jabatan untuk pelaksana operasional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supervisor',
                'description' => 'Level jabatan pengawas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'description' => 'Level jabatan manajerial.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Placements (Penempatan)
        DB::table('placements')->insert([
            [
                'name' => 'PT. Cahaya Fajar Kaltim',
                'address' => 'Alamat PT. Cahaya Fajar Kaltim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Indonesia Energi Dinamika',
                'address' => 'Alamat PT. Indonesia Energi Dinamika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Lombok Energy Dynamic',
                'address' => 'Alamat PT. Lombok Energy Dynamic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Benefit Categories (Kategori Manfaat)
        DB::table('benefit_categories')->insert([
            [
                'name' => 'Tunjangan Kesehatan',
                'icon' => 'heart-pulse',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tunjangan Transportasi',
                'icon' => 'bus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bonus Tahunan',
                'icon' => 'gift',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
