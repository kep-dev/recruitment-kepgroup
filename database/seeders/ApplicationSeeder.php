<?php

namespace Database\Seeders;

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

        $users        = DB::table('users')->get(); // semua user
        $jobVacancies = DB::table('job_vacancies')->get();

        if ($users->isEmpty() || $jobVacancies->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data users atau job_vacancies. Jalankan seeder User/JobVacancy dulu.');
            return;
        }

        // Buat minimal 20 lamaran acak
        for ($i = 0; $i < 20; $i++) {
            $user        = $users->random();
            $jobVacancy  = $jobVacancies->random();

            DB::table('applications')->insert([
                'id'             => (string) Str::uuid(),
                'user_id'        => $user->id,
                'job_vacancy_id' => $jobVacancy->id,
                'status'         => $faker->randomElement(['pending']),
                'note'           => $faker->optional()->sentence(),
                'created_at'     => now()->subDays(rand(0, 30)),
                'updated_at'     => now(),
            ]);
        }
    }
}
