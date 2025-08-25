<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 10; $i++) {
            $userId = (string) Str::uuid();

            // ===== Users =====
            $user = User::create([
                'id'       => $userId,
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'), // default password
            ]);

            // assign role applicant (pastikan role 'applicant' sudah ada)
            $user->assignRole('applicant');

            // ===== Applicants =====
            $applicantId = (string) Str::uuid();
            DB::table('applicants')->insert([
                'id'            => $applicantId,
                'user_id'       => $userId,
                'nik'           => $faker->nik(),
                'date_of_birth' => $faker->date(),
                'phone_number'  => $faker->phoneNumber(),
                'gender'        => $faker->randomElement(['male', 'female']),
                'city'          => $faker->city(),
                'province'      => $faker->state(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // ===== Education =====
            DB::table('educations')->insert([
                'id'              => (string) Str::uuid(),
                'user_id'         => $userId,
                'education_level' => $faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
                'major'           => $faker->word() . ' Engineering',
                'university'      => $faker->company() . ' University',
                'location'        => $faker->city(),
                'graduation_year' => $faker->year(),
                'gpa'             => $faker->randomFloat(2, 2.5, 4.0),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // ===== Work Experience =====
            DB::table('work_experiences')->insert([
                'id'                => (string) Str::uuid(),
                'user_id'           => $userId,
                'job_title'         => $faker->jobTitle(),
                'company_name'      => $faker->company(),
                'job_position'      => $faker->randomElement(['Staff', 'Supervisor', 'Manager']),
                'industry'          => $faker->randomElement(['Energi', 'Manufacturing', 'IT', 'Finance']),
                'start_date'        => $faker->dateTimeBetween('-5 years', '-2 years'),
                'end_date'          => $faker->dateTimeBetween('-2 years', 'now'),
                'currently_working' => false,
                'description'       => $faker->sentence(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // ===== Organizational Experience =====
            DB::table('organizational_experiences')->insert([
                'id'               => (string) Str::uuid(),
                'organization_name' => $faker->company(),
                'position'         => $faker->jobTitle(),
                'level'            => $faker->randomElement(['Regional', 'National', 'International']),
                'start_date'       => $faker->dateTimeBetween('-8 years', '-5 years'),
                'end_date'         => $faker->dateTimeBetween('-5 years', '-2 years'),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // ===== Training / Certification =====
            DB::table('training_certifications')->insert([
                'id'                        => (string) Str::uuid(),
                'user_id'                   => $userId,
                'training_certification_title' => 'Training ' . $faker->word(),
                'institution_name'          => $faker->company(),
                'type'                      => $faker->randomElement(['training', 'certification']),
                'location'                  => $faker->city(),
                'start_date'                => $faker->dateTimeBetween('-3 years', '-1 years'),
                'end_date'                  => $faker->dateTimeBetween('-1 years', 'now'),
                'description'               => $faker->sentence(10),
                'created_at'                => now(),
                'updated_at'                => now(),
            ]);

            // ===== Achievements =====
            DB::table('achievments')->insert([
                'id'               => (string) Str::uuid(),
                'user_id'          => $userId,
                'achievment_name'  => 'Juara ' . $faker->word(),
                'organization_name' => $faker->company(),
                'year'             => $faker->year(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // ===== Languages =====
            DB::table('languages')->insert([
                'id'        => (string) Str::uuid(),
                'user_id'   => $userId,
                'language'  => $faker->randomElement(['English', 'Indonesia', 'Mandarin', 'Japanese']),
                'level'     => $faker->randomElement(['Beginner', 'Intermediate', 'Advanced', 'Fluent']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ===== Skills =====
            DB::table('skills')->insert([
                'id'        => (string) Str::uuid(),
                'user_id'   => $userId,
                'skill'     => $faker->randomElement(['Leadership', 'Communication', 'Programming', 'Problem Solving', 'Time Management']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ===== Social Media =====
            DB::table('social_media')->insert([
                'id'      => (string) Str::uuid(),
                'user_id' => $userId,
                'name'    => 'LinkedIn',
                'url'     => 'https://linkedin.com/in/' . $faker->userName(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ===== Function of Interests =====
            DB::table('function_of_interests')->insert([
                'id'      => (string) Str::uuid(),
                'user_id' => $userId,
                'function_of_interest' => $faker->randomElement(['Engineering', 'Finance', 'HR', 'Operations']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ===== Salaries =====
            DB::table('salaries')->insert([
                'id'             => (string) Str::uuid(),
                'user_id'        => $userId,
                'expected_salary' => $faker->numberBetween(5000000, 12000000),
                'current_salary' => $faker->numberBetween(4000000, 10000000),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
