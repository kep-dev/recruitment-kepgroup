<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Safety: pastikan ada user sebagai creator ---
        $userId = DB::table('users')->inRandomOrder()->value('id');
        if (! $userId) {
            $userId = (string) Str::uuid();
            DB::table('users')->insert([
                'id'         => $userId,
                'name'       => 'Seeder Admin',
                'email'      => 'seeder.admin@example.com',
                'password'   => bcrypt('password'), // ganti bila perlu
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --- Ambil referensi master ---
        $workTypes   = DB::table('work_types')->pluck('id', 'name');              // ['Work From Office' => '...uuid...']
        $empTypes    = DB::table('employee_types')->pluck('id', 'name');          // ['Karyawan Tetap' => '...uuid...']
        $jobLevels   = DB::table('job_levels')->pluck('id', 'name');              // ['Staff' => '...uuid...', 'Supervisor' => '...uuid...']
        $placements  = DB::table('placements')->pluck('id')->all();               // ['uuid1', 'uuid2', ...]
        $benefits    = DB::table('benefit_categories')->pluck('id', 'name');      // ['Tunjangan Kesehatan' => 'uuid', ...]

        // Validasi minimal data master
        foreach (
            [
                'work_types' => $workTypes,
                'employee_types' => $empTypes,
                'job_levels' => $jobLevels,
                'placements' => $placements,
                'benefit_categories' => $benefits,
            ] as $table => $vals
        ) {
            if (empty($vals) || (is_object($vals) && $vals->isEmpty())) {
                throw new \RuntimeException("Seeder gagal: tabel master '{$table}' kosong. Mohon isi master terlebih dahulu.");
            }
        }

        // Helper untuk ambil id berdasarkan nama dengan fallback random
        $pickByNameOrRandom = function ($bucket, $name) {
            if (isset($bucket[$name])) return $bucket[$name];
            // fallback: ambil id random
            if (is_object($bucket)) {
                return $bucket->values()->random();
            }
            // array biasa
            return is_array($bucket) && count($bucket)
                ? (is_string(array_key_first($bucket)) ? $bucket[array_rand($bucket)] : $bucket[array_rand($bucket)])
                : null;
        };

        // Pool judul lowongan (bisa kamu tambah/ubah)
        $titles = [
            'Operator Turbin',
            'Operator Boiler',
            'Teknisi Listrik',
            'Mekanik',
            'QC Inspector',
            'Warehouse Supervisor',
            'Supervisor Produksi',
            'Foreman Turbin',
            'Foreman Boiler',
            'Admin HR',
            'Procurement Staff',
            'IT Support',
            'Drafter',
            'Engineer Instrument',
            'Operator Genset',
            'Health & Safety Officer',
            'Planner Maintenance',
            'Logistic Coordinator',
            'QA Engineer',
            'Utility Technician',
            'Staff Payroll',
            'Receptionist',
        ];

        // Deskripsi & requirement template singkat
        $descPool = [
            'Bertanggung jawab atas kelancaran operasional harian dan memastikan standar keselamatan serta kualitas terpenuhi.',
            'Melakukan pemeliharaan, troubleshooting, serta perbaikan peralatan untuk menjaga ketersediaan sistem.',
            'Berkoordinasi lintas tim untuk perencanaan kerja, pelaporan, dan continuous improvement.',
        ];
        $reqPool = [
            "- Pendidikan minimal SMK/D3/S1 sesuai bidang\n- Pengalaman sesuai posisi lebih disukai\n- Mampu bekerja dalam tim\n- Bersedia bekerja shift jika diperlukan",
            "- Menguasai dasar K3\n- Memiliki komunikasi yang baik\n- Mampu membaca SOP/diagram teknis\n- Teliti dan bertanggung jawab",
            "- Familiar dengan tools/CMMS\n- Siap ditempatkan sesuai kebutuhan\n- Mampu bekerja dengan target\n- Integritas tinggi",
        ];

        // Images placeholder (aman-aman saja)
        $images = [
            'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb',
            'https://images.unsplash.com/photo-1581090700227-1e37b190418e',
            'https://images.unsplash.com/photo-1581091014534-7d5a3b9a9ee2',
            'https://images.unsplash.com/photo-1518770660439-4636190af475',
            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a',
        ];

        // Pemetaan gaji dasar per level (silakan sesuaikan)
        $salaryBaseByLevel = [
            'Staff'      => [4_500_000, 6_500_000],
            'Supervisor' => [7_500_000, 10_000_000],
            'Manager'    => [12_000_000, 18_000_000],
        ];

        // Tentukan jumlah lowongan
        $count = 20; // ganti ke 10 kalau mau 10

        DB::transaction(function () use (
            $count,
            $userId,
            $workTypes,
            $empTypes,
            $jobLevels,
            $placements,
            $benefits,
            $titles,
            $descPool,
            $reqPool,
            $images,
            $salaryBaseByLevel,
            $pickByNameOrRandom
        ) {
            for ($i = 1; $i <= $count; $i++) {
                // Pilih data referensi
                $workTypeId = $pickByNameOrRandom($workTypes, 'Work From Office'); // default WFO jika ada
                $empTypeId  = $pickByNameOrRandom($empTypes, 'Karyawan Tetap');    // default Tetap jika ada

                // Pilih level (prefer Staff/Supervisor jika ada)
                $levelNameOptions = array_intersect(['Staff', 'Supervisor', 'Manager'], array_keys(is_object($jobLevels) ? $jobLevels->toArray() : $jobLevels));
                $levelName = !empty($levelNameOptions)
                    ? (array_values($levelNameOptions))[array_rand($levelNameOptions)]
                    : (is_object($jobLevels) ? array_rand($jobLevels->toArray()) : array_rand($jobLevels)); // fallback nama acak

                $levelId = $pickByNameOrRandom($jobLevels, $levelName);

                // Tentukan salary range
                $salaryRange = $salaryBaseByLevel[$levelName] ?? [4_000_000, 8_000_000];
                $salary = random_int($salaryRange[0], $salaryRange[1]);

                // Judul & slug unik
                $title = $titles[array_rand($titles)];
                $slug  = Str::slug($title) . '-' . Str::lower(Str::random(6));

                // Isi deskripsi/requirement
                $description  = $descPool[array_rand($descPool)];
                $requirements = $reqPool[array_rand($reqPool)];

                $vacancyId = (string) Str::uuid();

                // Insert job_vacancies
                DB::table('job_vacancies')->insert([
                    'id'               => $vacancyId,
                    'user_id'          => $userId,
                    'work_type_id'     => $workTypeId,
                    'employee_type_id' => $empTypeId,
                    'job_level_id'     => $levelId,
                    'title'            => $title,
                    'slug'             => $slug,
                    'image'            => $images[array_rand($images)],
                    'description'      => $description,
                    'requirements'     => $requirements,
                    'end_date'         => now()->addDays(random_int(30, 90)),
                    'status'           => true,
                    'salary'           => $salary,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                // Placements: 1–2 lokasi
                $placementPick = $placements;
                shuffle($placementPick);
                $placementPick = array_slice($placementPick, 0, random_int(1, min(2, count($placements))));
                foreach ($placementPick as $pid) {
                    DB::table('job_vacancy_placements')->insert([
                        'id'             => (string) Str::uuid(),
                        'job_vacancy_id' => $vacancyId,
                        'placement_id'   => $pid,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }

                // Benefits: 1–3 kategori
                $benefitNames = array_keys(is_object($benefits) ? $benefits->toArray() : $benefits);
                if (! empty($benefitNames)) {
                    shuffle($benefitNames);
                    $chosen = array_slice($benefitNames, 0, random_int(1, min(3, count($benefitNames))));
                    foreach ($chosen as $bName) {
                        $benefitId = $benefits[$bName]; // id by name
                        DB::table('job_vacancy_benefits')->insert([
                            'id'                 => (string) Str::uuid(),
                            'job_vacancy_id'     => $vacancyId,
                            'benefit_category_id' => $benefitId,
                            'description'        => "Fasilitas {$bName} untuk karyawan",
                            'created_at'         => now(),
                            'updated_at'         => now(),
                        ]);
                    }
                }
            }
        });
    }
}
