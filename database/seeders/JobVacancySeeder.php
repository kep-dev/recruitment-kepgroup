<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data referensi dari master table
        $workTypeWfo     = DB::table('work_types')->where('name', 'Work From Office')->first();
        $employeeTetap   = DB::table('employee_types')->where('name', 'Karyawan Tetap')->first();
        $levelStaff      = DB::table('job_levels')->where('name', 'Staff')->first();
        $levelSupervisor = DB::table('job_levels')->where('name', 'Supervisor')->first();

        $placementKaltim = DB::table('placements')->where('name', 'PT. Cahaya Fajar Kaltim')->first();
        $placementIED    = DB::table('placements')->where('name', 'PT. Indonesia Energi Dinamika')->first();

        $benefitHealth   = DB::table('benefit_categories')->where('name', 'Tunjangan Kesehatan')->first();
        $benefitTrans    = DB::table('benefit_categories')->where('name', 'Tunjangan Transportasi')->first();
        $benefitBonus    = DB::table('benefit_categories')->where('name', 'Bonus Tahunan')->first();

        // ========== Lowongan 1 ==========
        $vacancyId1 = (string) Str::uuid();
        DB::table('job_vacancies')->insert([
            'id'              => $vacancyId1,
            'user_id'         => DB::table('users')->first()->id, // ambil user pertama sbg creator
            'work_type_id'    => $workTypeWfo->id,
            'employee_type_id' => $employeeTetap->id,
            'job_level_id'    => $levelStaff->id,
            'title'           => 'Operator Turbin',
            'slug'            => 'operator-turbin',
            'image'           => 'https://www.shutterstock.com/image-photo/engineer-checking-wind-turbine-laptop-123456789',
            'description'     => 'Mengoperasikan dan memelihara turbin di unit pembangkit listrik.',
            'requirements'    => '- Pendidikan minimal D3 Teknik Mesin / Elektro
- Pengalaman 1 tahun di bidang pembangkit listrik lebih disukai
- Bersedia bekerja shift',
            'end_date'        => now()->addDays(30),
            'status'          => true,
            'salary'          => 5000000, // gaji pokok
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Benefits untuk Lowongan 1
        DB::table('job_vacancy_benefits')->insert([
            [
                'id'                 => (string) Str::uuid(),
                'job_vacancy_id'     => $vacancyId1,
                'benefit_category_id' => $benefitHealth->id,
                'description'        => 'Asuransi kesehatan untuk karyawan dan keluarga inti',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => (string) Str::uuid(),
                'job_vacancy_id'     => $vacancyId1,
                'benefit_category_id' => $benefitTrans->id,
                'description'        => 'Tunjangan transportasi harian',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);

        // Placements untuk Lowongan 1
        DB::table('job_vacancy_placements')->insert([
            'id'             => (string) Str::uuid(),
            'job_vacancy_id' => $vacancyId1,
            'placement_id'   => $placementKaltim->id,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // ========== Lowongan 2 ==========
        $vacancyId2 = (string) Str::uuid();
        DB::table('job_vacancies')->insert([
            'id'              => $vacancyId2,
            'user_id'         => DB::table('users')->first()->id,
            'work_type_id'    => $workTypeWfo->id,
            'employee_type_id' => $employeeTetap->id,
            'job_level_id'    => $levelSupervisor->id,
            'title'           => 'Supervisor Boiler',
            'slug'            => 'supervisor-boiler',
            'image'           => 'https://www.gettyimages.com/detail/photo/female-engineer-checking-boiler-123456789',
            'description'     => 'Mengawasi operasional boiler dan memastikan keselamatan kerja.',
            'requirements'    => '- Pendidikan minimal S1 Teknik Mesin
- Pengalaman minimal 3 tahun di bidang boiler
- Mampu memimpin tim',
            'end_date'        => now()->addDays(45),
            'status'          => true,
            'salary'          => 8000000,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Benefits untuk Lowongan 2
        DB::table('job_vacancy_benefits')->insert([
            [
                'id'                 => (string) Str::uuid(),
                'job_vacancy_id'     => $vacancyId2,
                'benefit_category_id' => $benefitHealth->id,
                'description'        => 'Asuransi kesehatan komprehensif',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => (string) Str::uuid(),
                'job_vacancy_id'     => $vacancyId2,
                'benefit_category_id' => $benefitBonus->id,
                'description'        => 'Bonus tahunan berdasarkan kinerja',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);

        // Placements untuk Lowongan 2
        DB::table('job_vacancy_placements')->insert([
            'id'             => (string) Str::uuid(),
            'job_vacancy_id' => $vacancyId2,
            'placement_id'   => $placementIED->id,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
