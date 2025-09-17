<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil data master
        $users = DB::table('users')->get();
        $vacancies = DB::table('job_vacancies')->get();

        if ($users->isEmpty() || $vacancies->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data users atau job_vacancies. Jalankan seeder User & JobVacancy dulu.');
            return;
        }

        DB::transaction(function () use ($faker, $users, $vacancies) {
            foreach ($vacancies as $vacancy) {
                // Banyaknya aplikasi untuk lowongan ini
                $applicationsCount = random_int(3, 8);

                // Hindari creator lowongan sebagai pelamar (opsional)
                $eligibleUsers = $users->where('id', '!=', $vacancy->user_id)->values();

                // Jika eligible kosong (misal cuma 1 user), pakai semua user
                if ($eligibleUsers->isEmpty()) {
                    $eligibleUsers = $users->values();
                }

                // Ambil user random unik
                $pickedUsers = $eligibleUsers->random(min($applicationsCount, $eligibleUsers->count()))->values();

                foreach ($pickedUsers as $user) {
                    // Cek kalau sudah ada aplikasi untuk pasangan (user, vacancy) ini
                    $exists = DB::table('applications')
                        ->where('user_id', $user->id)
                        ->where('job_vacancy_id', $vacancy->id)
                        ->exists();

                    if ($exists) {
                        continue;
                    }

                    // Tentukan batas waktu pembuatan aplikasi: sebelum end_date (atau sekarang jika end_date lewat)
                    $endDate = $vacancy->end_date ? Carbon::parse($vacancy->end_date) : now();
                    $upperBound = $endDate->isFuture() ? $endDate : now();

                    // Buat created_at antara 90 hari terakhir sampai upperBound
                    // Agar tidak melebihi upperBound (dan tidak di masa depan)
                    $createdAt = Carbon::instance(
                        $faker->dateTimeBetween('-90 days', $upperBound->toDateTimeString())
                    );

                    DB::table('applications')->insert([
                        'id'              => (string) Str::uuid(),
                        'user_id'         => $user->id,
                        'job_vacancy_id'  => $vacancy->id,
                        'current_stage_id' => null,
                        'final_status'    => 'pending', // bisa kamu ganti enum lain: accepted/rejected dsb
                        'note'            => $faker->optional()->sentence(),
                        'created_at'      => $createdAt,
                        'updated_at'      => $createdAt->copy()->addDays(random_int(0, 5)),
                    ]);
                }
            }
        });

        $this->command->info('✅ Applications seeded berdasarkan setiap Job Vacancy (tanpa duplikasi & tanggal selaras end_date).');
    }
}
