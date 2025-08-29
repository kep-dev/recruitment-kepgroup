<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // Helper: insert question + choices (if any)
        $insertQuestion = function (string $testId, array $q) use ($now) {
            $questionId = (string) Str::uuid();

            DB::table('questions')->insert([
                'id'            => $questionId,
                'test_id'       => $testId,
                'question_text' => $q['text'],
                'type'          => $q['type'],
                'points'        => $q['points'] ?? 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);

            // Insert choices if provided (for multiple_choice / true_false / fill_in as options)
            if (!empty($q['choices']) && is_array($q['choices'])) {
                $rows = [];
                foreach ($q['choices'] as $choice) {
                    $rows[] = [
                        'id'           => (string) Str::uuid(),
                        'question_id'  => $questionId,
                        'choice_label' => $choice['label'],
                        'choice_text'  => $choice['text'],
                        'is_correct'   => (bool) ($choice['correct'] ?? false),
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
                DB::table('question_choices')->insert($rows);
            }
        };

        // ===========================
        // TEST 1: PSIKOLOGI (12 soal)
        // ===========================
        $psikologiId = (string) Str::uuid();
        DB::table('tests')->insert([
            'id'                   => $psikologiId,
            'user_id'              => null,
            'title'                => 'Tes Psikologi',
            'description'          => 'Tes mengukur preferensi kerja, stabilitas emosi, dan gaya berpikir.',
            'duration_in_minutes'  => 35,
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $psikologiQuestions = [
            // Likert-style (multiple_choice)
            [
                'text' => 'Saya merasa berenergi saat bekerja sama dalam tim.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Sangat Tidak Setuju', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Tidak Setuju', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Setuju', 'is_correct' => true],   // pilih satu sebagai “benar” dummy
                    ['label' => 'D', 'text' => 'Sangat Setuju', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Saya tetap tenang ketika menghadapi tenggat waktu yang ketat.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Sangat Tidak Setuju', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Tidak Setuju', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Setuju', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Sangat Setuju', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Saya nyaman menerima masukan/umpan balik yang kritis.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Sangat Tidak Setuju', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Tidak Setuju', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Setuju', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Sangat Setuju', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Saya cenderung mengambil keputusan berdasarkan data, bukan intuisi.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Sangat Tidak Setuju', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Tidak Setuju', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Setuju', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Sangat Setuju', 'is_correct' => false],
                ],
            ],
            // True/False
            [
                'text' => 'Saya lebih produktif ketika bekerja sendiri dibandingkan dalam kelompok.',
                'type' => 'true_false',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Benar', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Salah', 'is_correct' => true],
                ],
            ],
            [
                'text' => 'Saya mudah terdistraksi ketika bekerja di lingkungan yang ramai.',
                'type' => 'true_false',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Benar', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Salah', 'is_correct' => false],
                ],
            ],
            // Essay (dinilai manual)
            [
                'text' => 'Ceritakan situasi saat Anda menghadapi konflik di tim dan bagaimana Anda menyelesaikannya.',
                'type' => 'essay',
                'points' => 3,
            ],
            [
                'text' => 'Apa yang memotivasi Anda saat menghadapi tugas yang membosankan?',
                'type' => 'essay',
                'points' => 3,
            ],
            // Additional Likert/MC
            [
                'text' => 'Saya menyusun rencana kerja sebelum memulai tugas.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Jarang', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Kadang-kadang', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Sering', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Selalu', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Saya mampu beradaptasi ketika prioritas kerja berubah mendadak.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Sangat Tidak Setuju', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Tidak Setuju', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Setuju', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Sangat Setuju', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Saya lebih menyukai instruksi yang jelas daripada kebebasan penuh.',
                'type' => 'true_false',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Benar', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Salah', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Saya ingin berperan sebagai pemimpin ketika anggota tim ragu mengambil keputusan.',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Tidak Pernah', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Kadang', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Sering', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Selalu', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($psikologiQuestions as $q) {
            $insertQuestion($psikologiId, $q);
        }

        // =================================
        // TEST 2: PENGETAHUAN UMUM (12 soal)
        // =================================
        $umumId = (string) Str::uuid();
        DB::table('tests')->insert([
            'id'                   => $umumId,
            'user_id'              => null,
            'title'                => 'Tes Pengetahuan Umum',
            'description'          => 'Tes mengukur wawasan umum kandidat (geografi, sejarah, sains dasar).',
            'duration_in_minutes'  => 25,
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $umumQuestions = [
            // MC
            [
                'text' => 'Ibukota Indonesia adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Jakarta', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Bandung', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Surabaya', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Medan', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Lambang unsur kimia “O” merujuk pada?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Oksigen', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Osmium', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Oganesson', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Ozonida', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Planet terbesar di tata surya adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Bumi', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Jupiter', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Saturnus', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Neptunus', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Gunung tertinggi di dunia (di atas permukaan laut) adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'K2', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Everest', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Kilimanjaro', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Elbrus', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Penemu lampu pijar yang populer adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Albert Einstein', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Isaac Newton', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Thomas A. Edison', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Nikola Tesla', 'is_correct' => false],
                ],
            ],
            // True/False
            [
                'text' => 'Laut Mati memiliki kadar garam yang tinggi sehingga manusia mudah mengapung.',
                'type' => 'true_false',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Benar', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Salah', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Hewan koala berasal dari benua Afrika.',
                'type' => 'true_false',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Benar', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Salah', 'is_correct' => true],
                ],
            ],
            // Essay
            [
                'text' => 'Jelaskan perbedaan antara cuaca dan iklim beserta contohnya.',
                'type' => 'essay',
                'points' => 3,
            ],
            [
                'text' => 'Sebutkan tiga contoh energi terbarukan dan manfaatnya.',
                'type' => 'essay',
                'points' => 3,
            ],
            // MC tambahan
            [
                'text' => 'Sungai terpanjang di dunia adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Nil', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Amazon', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Yangtze', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Mississippi', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Perang Dunia II berakhir pada tahun?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '1939', 'is_correct' => false],
                    ['label' => 'B', 'text' => '1943', 'is_correct' => false],
                    ['label' => 'C', 'text' => '1945', 'is_correct' => true],
                    ['label' => 'D', 'text' => '1950', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Bendera negara Jepang didominasi warna?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Merah dan Putih', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Merah dan Biru', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Hijau dan Kuning', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Hitam dan Putih', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($umumQuestions as $q) {
            $insertQuestion($umumId, $q);
        }
    }
}
