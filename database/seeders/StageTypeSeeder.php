<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stage_types')->insert([
            ['id' => Str::uuid(), 'code' => 'screening',     'name' => 'Seleksi Administrasi', 'is_terminal' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'code' => 'test',   'name' => 'Tes',   'is_terminal' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'code' => 'interview_hr',  'name' => 'Interview HR', 'is_terminal' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'code' => 'interview_user', 'name' => 'Interview User', 'is_terminal' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'code' => 'offering',      'name' => 'Offering',     'is_terminal' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'code' => 'hired',         'name' => 'Hired',        'is_terminal' => true,  'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'code' => 'rejected',      'name' => 'Rejected',     'is_terminal' => true,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
