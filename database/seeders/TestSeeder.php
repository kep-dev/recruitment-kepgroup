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
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $umumQuestions = [
            [
                'text' => 'Pusat peredaran tata surya adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Bulan', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Matahari', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Bumi', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Jupiter', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Bunga khas negeri Matahari Terbit adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Tulip', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Sakura', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Mawar', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Anggrek', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Daerah terkenal dengan ubi adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Cilembu', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Malang', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Garut', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Medan', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Planet merah adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Mars', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Jupiter', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Venus', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Merkurius', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Dasar negara Indonesia adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'UUD 1945', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Pancasila', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Proklamasi', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Bhinneka Tunggal Ika', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Bahan pembuat madu adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Serbuk sari bunga', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Tebu', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Kelapa', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Pohon karet', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Patung Liberty berada di pulau?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Liberty Island', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Ellis Island', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Manhattan', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Staten Island', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Mamalia tertinggi adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Gajah', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Jerapah', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Badak', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Sapi', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Hewan berkembang biak dengan membelah diri adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Bakteri', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Katak', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Kadal', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Ikan', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Lambang Pos Indonesia adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Burung Merpati', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Elang', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Harimau', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Bunga Teratai', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Kolektor perangko disebut?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Filatelis', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Numismatis', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Arkeolog', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Kartunis', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Percampuran warna kuning dan biru menghasilkan warna?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Hijau', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Ungu', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Coklat', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Oranye', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Pungutan liar biasa disebut?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Korupsi', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Pungli', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Sogokan', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Suap', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Kapal selam dalam bahasa Inggris disebut?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Submarine', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Ship', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Boat', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Cruiser', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Tim penyelamat disebut?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'SAR', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Polisi', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'PMI', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Damkar', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Besaran bunyi diukur dengan satuan?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Desibel', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Hertz', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Joule', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Newton', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Belanda dikenal juga dengan nama?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Holland', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Swiss', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Denmark', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Norwegia', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Tempat bersembunyi ikan badut adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Terumbu karang', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Anemon laut', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Rumput laut', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Mangrove', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Ilmu pengetahuan alam disebut juga?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Biologi', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'IPA', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'IPS', 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Fisika', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Tarian khas Pulau Bali adalah?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Tari Jaipong', 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Tari Saman', 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Tari Kecak', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Tari Piring', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($umumQuestions as $q) {
            $insertQuestion($umumId, $q);
        }

        // =================================
        // TEST 3: PERBANDINGAN KATA (20 soal)
        // =================================
        $kataId = (string) Str::uuid();
        DB::table('tests')->insert([
            'id'                   => $kataId,
            'user_id'              => null,
            'title'                => 'Tes Perbandingan Kata',
            'description'          => 'Tes mengukur pengetahuan tentang perbandingan kata',
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $kataQuestions = [
            // 1. AIR : HAUS → Makanan : Lapar (sebab → penangkal/ pemenuh kebutuhan)
            [
                'text' => 'AIR : HAUS  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Makanan : Lapar', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Angin : Panas'],
                    ['label' => 'C', 'text' => 'Rumput : Kambing'],
                    ['label' => 'D', 'text' => 'Minyak : Api'],
                    ['label' => 'E', 'text' => 'Cincin : Jari'],
                ],
            ],
            // 2. KAKI : SEPATU → Telinga : Anting (bagian tubuh : benda yang dikenakan)
            [
                'text' => 'KAKI : SEPATU  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Telinga : Anting', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Cat : Kuas'],
                    ['label' => 'C', 'text' => 'Meja : Ruangan'],
                    ['label' => 'D', 'text' => 'Topi : Kepala'],
                    ['label' => 'E', 'text' => 'Cincin : Jari'],
                ],
            ],
            // 3. PELUKIS : GAMBAR → Penyair : Puisi (profesi : karya)
            [
                'text' => 'PELUKIS : GAMBAR  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Penyair : Puisi', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Kartunis : Pena'],
                    ['label' => 'C', 'text' => 'Komponis : Gitar'],
                    ['label' => 'D', 'text' => 'Koki : Restoran'],
                    ['label' => 'E', 'text' => 'Penyanyi : Lagu'],
                ],
            ],
            // 4. KOSONG : HAMPA → Penuh : Sesak (sinonim/kemiripan tingkat)
            [
                'text' => 'KOSONG : HAMPA  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Penuh : Sesak', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Ubi : Akar'],
                    ['label' => 'C', 'text' => 'Cair : Encer'],
                    ['label' => 'D', 'text' => 'Siang : Malam'],
                    ['label' => 'E', 'text' => 'Ribut : Sorak'],
                ],
            ],
            // 5. KENDARAAN : MOBIL → Orang : Pemuda (kategori : anggota)
            [
                'text' => 'KENDARAAN : MOBIL  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Binatang : Hewan'],
                    ['label' => 'B', 'text' => 'Gaji : Upah'],
                    ['label' => 'C', 'text' => 'Laut : Danau'],
                    ['label' => 'D', 'text' => 'Orang : Pemuda', 'is_correct' => true],
                    ['label' => 'E', 'text' => 'Kapal : Perahu'],
                ],
            ],
            // 6. KITA : SAYA → Mereka : Dia (jamak : tunggal orang)
            [
                'text' => 'KITA : SAYA  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Dia : Kalian'],
                    ['label' => 'B', 'text' => 'Mereka : Dia', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Kami : Kamu'],
                    ['label' => 'D', 'text' => 'Beliau : Kami'],
                    ['label' => 'E', 'text' => 'Kalian : Beliau'],
                ],
            ],
            // 7. KIJANG : CEPAT → Siput : Lambat (subjek : sifat khas)
            [
                'text' => 'KIJANG : CEPAT  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Kuda : Delman'],
                    ['label' => 'B', 'text' => 'Siput : Lambat', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Bunga : Merah'],
                    ['label' => 'D', 'text' => 'Anjing : Menggonggong'],
                    ['label' => 'E', 'text' => 'Serigala : Kecil'],
                ],
            ],
            // 8. PETANI : CANGKUL → Nelayan : Jaring (pekerjaan : alat)
            [
                'text' => 'PETANI : CANGKUL  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Nelayan : Jaring', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Wartawan : Berita'],
                    ['label' => 'C', 'text' => 'Raja : Mahkota'],
                    ['label' => 'D', 'text' => 'Dalang : Cerita'],
                    ['label' => 'E', 'text' => 'Penjahit : Baju'],
                ],
            ],
            // 9. KAKATUA : MERPATI → Gurami : Kakap (dua spesies sekelas)
            [
                'text' => 'KAKATUA : MERPATI  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Anjing : Herder'],
                    ['label' => 'B', 'text' => 'Gurami : Kakap', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Gajah : Semut'],
                    ['label' => 'D', 'text' => 'Singa : Naga'],
                    ['label' => 'E', 'text' => 'Elang : Kupu-kupu'],
                ],
            ],
            //10. BELAJAR : PANDAI → Berpikir : Arif (sebab → akibat/sifat)
            [
                'text' => 'BELAJAR : PANDAI  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Cetak : Kertas'],
                    ['label' => 'B', 'text' => 'Berpikir : Arif', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Potret : Kamera'],
                    ['label' => 'D', 'text' => 'Litografi : Batu'],
                    ['label' => 'E', 'text' => 'Cetak : Tinta'],
                ],
            ],
            //11. KAMPUNG : SAWAH → Kota : Gedung (tempat : ciri umum)
            [
                'text' => 'KAMPUNG : SAWAH  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Kampus : Perpustakaan'],
                    ['label' => 'B', 'text' => 'Kota : Gedung', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Sawah : Padi'],
                    ['label' => 'D', 'text' => 'Bumbu : Dapur'],
                    ['label' => 'E', 'text' => 'Reserse : Polisi'],
                ],
            ],
            //12. JANJI : BUKTI → Ucapan : Tindakan (kata : pembuktian)
            [
                'text' => 'JANJI : BUKTI  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Ucapan : Tindakan', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Maling : Penjara'],
                    ['label' => 'C', 'text' => 'Materi : Soal'],
                    ['label' => 'D', 'text' => 'Harta : Kendaraan'],
                    ['label' => 'E', 'text' => 'Tuan : Tuhan'],
                ],
            ],
            //13. SUNGAI : JEMBATAN → Masalah : Jalan Keluar (rintangan : solusi)
            [
                'text' => 'SUNGAI : JEMBATAN  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Markah : Jalan'],
                    ['label' => 'B', 'text' => 'Rintangan : Godaan'],
                    ['label' => 'C', 'text' => 'Janji : Tepati'],
                    ['label' => 'D', 'text' => 'Kayu : Terbakar'],
                    ['label' => 'E', 'text' => 'Masalah : Jalan Keluar', 'is_correct' => true],
                ],
            ],
            //14. MATAHARI : TERANG → Api : Panas (sumber : akibat/sifat)
            [
                'text' => 'MATAHARI : TERANG  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Mendidih : Air'],
                    ['label' => 'B', 'text' => 'Membeku : Dingin'],
                    ['label' => 'C', 'text' => 'Lampu : Sinar'],
                    ['label' => 'D', 'text' => 'Air : Hujan'],
                    ['label' => 'E', 'text' => 'Api : Panas', 'is_correct' => true],
                ],
            ],
            //15. UMUM : LAZIM → Langsing : Ramping (sinonim)
            [
                'text' => 'UMUM : LAZIM  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Kurus : Gemuk'],
                    ['label' => 'B', 'text' => 'Langsing : Ramping', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Lapar : Haus'],
                    ['label' => 'D', 'text' => 'Garam : Asin'],
                    ['label' => 'E', 'text' => 'Cinta : Tinta'],
                ],
            ],
            //16. SISWA : BELAJAR → Ilmuwan : Meneliti (pelaku : aktivitas)
            [
                'text' => 'SISWA : BELAJAR  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Santri : Garam'],
                    ['label' => 'B', 'text' => 'Ayah : Ibu'],
                    ['label' => 'C', 'text' => 'Ilmuwan : Meneliti', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Guru : Murid'],
                    ['label' => 'E', 'text' => 'Karyawan : Bekerja'],
                ],
            ],
            //17. AIR : ES → Uap : Air (perubahan wujud benda)
            [
                'text' => 'AIR : ES  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Uap : Air', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Uap : Udara'],
                    ['label' => 'C', 'text' => 'Uap : Basah'],
                    ['label' => 'D', 'text' => 'Uap : Mendidih'],
                    ['label' => 'E', 'text' => 'Uap : Awan'],
                ],
            ],
            //18. APOTEKER : OBAT → Koki : Masakan (profesi : hasil/produk)
            [
                'text' => 'APOTEKER : OBAT  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Pesawat : Penyakit'],
                    ['label' => 'B', 'text' => 'Koki : Masakan', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Montir : Rusak'],
                    ['label' => 'D', 'text' => 'Mentor : Dril'],
                    ['label' => 'E', 'text' => 'Psikiater : Ide'],
                ],
            ],
            //19. PILOT : PESAWAT → Sopir : Mobil (profesi : kendaraan yang dikemudikan)
            [
                'text' => 'PILOT : PESAWAT  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Masinis : Kapal'],
                    ['label' => 'B', 'text' => 'Kusir : Kereta'],
                    ['label' => 'C', 'text' => 'Nelayan : Kapal'],
                    ['label' => 'D', 'text' => 'Motor : Truk'],
                    ['label' => 'E', 'text' => 'Sopir : Mobil', 'is_correct' => true],
                ],
            ],
            //20. GELOMBANG : OMBAK → Nadir : Zenit (istilah pasangan berlawanan/saling terkait)
            [
                'text' => 'GELOMBANG : OMBAK  — pasangan yang setara adalah ...',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Gunung : Bukit'],
                    ['label' => 'B', 'text' => 'Berenang : Lari'],
                    ['label' => 'C', 'text' => 'Danau : Laut'],
                    ['label' => 'D', 'text' => 'Nusa : Pulau'],
                    ['label' => 'E', 'text' => 'Nadir : Zenit', 'is_correct' => true],
                ],
            ],
        ];

        foreach ($kataQuestions as $q) {
            $insertQuestion($kataId, $q);
        }

        // =================================
        // TEST 5: MATEMATIKA DASAR (20 soal)
        // =================================
        $mathId = (string) Str::uuid();
        DB::table('tests')->insert([
            'id'                   => $mathId,
            'user_id'              => null,
            'title'                => 'Tes Matematika Dasar',
            'description'          => 'Tes Matematika Dasar',
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $mathQuestions = [
            [
                'text' => '1) 8 × 0.375 – 2 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '0'],
                    ['label' => 'B', 'text' => '1', 'is_correct' => true],
                    ['label' => 'C', 'text' => '2'],
                    ['label' => 'D', 'text' => '3'],
                ]
            ],
            [
                'text' => '2) 3 × 4 ÷ 3 + 84 + 9 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '96'],
                    ['label' => 'B', 'text' => '97', 'is_correct' => true],
                    ['label' => 'C', 'text' => '98'],
                    ['label' => 'D', 'text' => '93'],
                ]
            ],
            [
                'text' => '3) (15 × 5 + 5 + 2) ÷ 82 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '0'],
                    ['label' => 'B', 'text' => '1', 'is_correct' => true],
                    ['label' => 'C', 'text' => '2'],
                    ['label' => 'D', 'text' => '82'],
                ]
            ],
            [
                'text' => '4) 1000 ÷ 500 + 98 – 90 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '8'],
                    ['label' => 'B', 'text' => '10', 'is_correct' => true],
                    ['label' => 'C', 'text' => '12'],
                    ['label' => 'D', 'text' => '100'],
                ]
            ],
            [
                'text' => '5) (60 + 25 + 40 + 10) ÷ 5 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '25'],
                    ['label' => 'B', 'text' => '26'],
                    ['label' => 'C', 'text' => '27', 'is_correct' => true],
                    ['label' => 'D', 'text' => '30'],
                ]
            ],
            [
                'text' => '6) 80 ÷ 40 + 60 – 7 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '53'],
                    ['label' => 'B', 'text' => '55', 'is_correct' => true],
                    ['label' => 'C', 'text' => '57'],
                    ['label' => 'D', 'text' => '60'],
                ]
            ],
            [
                'text' => '7) 8 + 1 + 5 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '12'],
                    ['label' => 'B', 'text' => '13'],
                    ['label' => 'C', 'text' => '14', 'is_correct' => true],
                    ['label' => 'D', 'text' => '15'],
                ]
            ],
            [
                'text' => '8) 10 × 2 × 3 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '23'],
                    ['label' => 'B', 'text' => '30'],
                    ['label' => 'C', 'text' => '50'],
                    ['label' => 'D', 'text' => '60', 'is_correct' => true],
                ]
            ],
            [
                'text' => '9) 1 – 1 × 1 – 1 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '1'],
                    ['label' => 'B', 'text' => '0'],
                    ['label' => 'C', 'text' => '-1', 'is_correct' => true],
                    ['label' => 'D', 'text' => '-2'],
                ]
            ],
            [
                'text' => '10) 4 × 5 ÷ 1 – 3 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '15'],
                    ['label' => 'B', 'text' => '17', 'is_correct' => true],
                    ['label' => 'C', 'text' => '18'],
                    ['label' => 'D', 'text' => '20'],
                ]
            ],
            [
                'text' => '11) 3 × 3 ÷ 3 + 21 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '23'],
                    ['label' => 'B', 'text' => '24', 'is_correct' => true],
                    ['label' => 'C', 'text' => '27'],
                    ['label' => 'D', 'text' => '30'],
                ]
            ],
            [
                'text' => '12) 100 × 10 ÷ 100 – 9 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '0'],
                    ['label' => 'B', 'text' => '1', 'is_correct' => true],
                    ['label' => 'C', 'text' => '9'],
                    ['label' => 'D', 'text' => '19'],
                ]
            ],
            [
                'text' => '13) (10 + 41 + 9) ÷ 60 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '0'],
                    ['label' => 'B', 'text' => '1', 'is_correct' => true],
                    ['label' => 'C', 'text' => '2'],
                    ['label' => 'D', 'text' => '60'],
                ]
            ],
            [
                'text' => '14) 7 × 14 ÷ 49 + 9 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '9'],
                    ['label' => 'B', 'text' => '11', 'is_correct' => true],
                    ['label' => 'C', 'text' => '13'],
                    ['label' => 'D', 'text' => '7'],
                ]
            ],
            [
                'text' => '15) 18 × 12 ÷ 2 + 7 – 87 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '21'],
                    ['label' => 'B', 'text' => '28', 'is_correct' => true],
                    ['label' => 'C', 'text' => '31'],
                    ['label' => 'D', 'text' => '35'],
                ]
            ],
            [
                'text' => '16) 4 × 9 + 29 – 7 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '52'],
                    ['label' => 'B', 'text' => '57'],
                    ['label' => 'C', 'text' => '58', 'is_correct' => true],
                    ['label' => 'D', 'text' => '60'],
                ]
            ],
            [
                'text' => '17) 16 × 2 ÷ 8 – 4 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '-4'],
                    ['label' => 'B', 'text' => '0', 'is_correct' => true],
                    ['label' => 'C', 'text' => '2'],
                    ['label' => 'D', 'text' => '4'],
                ]
            ],
            [
                'text' => '18) (12 + 28 + 4 + 4) ÷ 4 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '10'],
                    ['label' => 'B', 'text' => '12', 'is_correct' => true],
                    ['label' => 'C', 'text' => '14'],
                    ['label' => 'D', 'text' => '16'],
                ]
            ],
            [
                'text' => '19) 40 × 90 ÷ 45 – 48 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '28'],
                    ['label' => 'B', 'text' => '32', 'is_correct' => true],
                    ['label' => 'C', 'text' => '36'],
                    ['label' => 'D', 'text' => '40'],
                ]
            ],
            [
                'text' => '20) 0.125 × 8 + 3 = …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '2'],
                    ['label' => 'B', 'text' => '3'],
                    ['label' => 'C', 'text' => '4', 'is_correct' => true],
                    ['label' => 'D', 'text' => '5'],
                ]
            ],
        ];

        foreach ($mathQuestions as $q) {
            $insertQuestion($mathId, $q);
        }

        // =================================
        // TEST 3: Kewarganegaraan (20 soal)
        // =================================
        $kewarganegaraanId = (string) Str::uuid();
        DB::table('tests')->insert([
            'id'                   => $kewarganegaraanId,
            'user_id'              => null,
            'title'                => 'Tes Kewarganegaraan',
            'description'          => 'Tes Kewarganegaraan',
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $kewarganegaraanQuestions = [
            [
                'text' => '1) Dasar negara Republik Indonesia adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'UUD 1945'],
                    ['label' => 'B', 'text' => 'Pancasila', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Sumpah Pemuda'],
                    ['label' => 'D', 'text' => 'Proklamasi'],
                ]
            ],
            [
                'text' => '2) Istilah Pancasila diperkenalkan Bung Karno pada sidang BPUPKI tanggal …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '01 Juni 1945', 'is_correct' => true],
                    ['label' => 'B', 'text' => '29 Mei 1945'],
                    ['label' => 'C', 'text' => '31 Mei 1945'],
                    ['label' => 'D', 'text' => '02 Juni 1945'],
                ]
            ],
            [
                'text' => '3) Cinta tanah air dapat dibuktikan dengan …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Mengekspor semua hasil bumi'],
                    ['label' => 'B', 'text' => 'Tidak melakukan hubungan dengan negara lain'],
                    ['label' => 'C', 'text' => 'Menggunakan produk dalam negeri', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Mengurangi impor agar devisa stabil'],
                ]
            ],
            [
                'text' => '4) “Kemanusiaan yang adil dan beradab” adalah sila ke …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '1'],
                    ['label' => 'B', 'text' => '2', 'is_correct' => true],
                    ['label' => 'C', 'text' => '3'],
                    ['label' => 'D', 'text' => '4'],
                ]
            ],
            [
                'text' => '5) Menurut pasal 1 ayat 1 UUD 1945, bentuk negara Indonesia adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Republik', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Presidensial'],
                    ['label' => 'C', 'text' => 'Parlementer'],
                    ['label' => 'D', 'text' => 'Demokrasi'],
                ]
            ],
            [
                'text' => '6) Dalam kehidupan bernegara, Pancasila berperan sebagai …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Dasar negara', 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Dasar kenegaraan'],
                    ['label' => 'C', 'text' => 'Dasar beragama'],
                    ['label' => 'D', 'text' => 'Dasar ketatanegaraan'],
                ]
            ],
            [
                'text' => '7) Berani membela kebenaran dan keadilan adalah pedoman untuk sila …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '1'],
                    ['label' => 'B', 'text' => '2'],
                    ['label' => 'C', 'text' => '3'],
                    ['label' => 'D', 'text' => '4', 'is_correct' => true],
                ]
            ],
            [
                'text' => '8) Pancasila secara formal disahkan sebagai dasar negara pada tanggal …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '01 Juni 1945'],
                    ['label' => 'B', 'text' => '17 Agustus 1945'],
                    ['label' => 'C', 'text' => '18 Agustus 1945', 'is_correct' => true],
                    ['label' => 'D', 'text' => '20 Agustus 1945'],
                ]
            ],
            [
                'text' => '9) Kekuasaan negara tertinggi berada di tangan …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Presiden'],
                    ['label' => 'B', 'text' => 'Presiden & Wakil Presiden'],
                    ['label' => 'C', 'text' => 'Dewan Perwakilan Rakyat'],
                    ['label' => 'D', 'text' => 'Majelis Permusyawaratan Rakyat', 'is_correct' => true],
                ]
            ],
            [
                'text' => '10) Toleransi antar umat beragama berarti …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Semua agama memiliki cara ibadah sama'],
                    ['label' => 'B', 'text' => 'Orang boleh berganti agama setiap saat'],
                    ['label' => 'C', 'text' => 'Menghargai aktivitas antar/ interumat beragama & pemerintah', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Persebaran agama bebas kepada siapapun'],
                ]
            ],
            [
                'text' => '11) Prinsip demokrasi di desa tercermin pada kegiatan bersama, kecuali …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Partisipasi'],
                    ['label' => 'B', 'text' => 'Sumbangan'],
                    ['label' => 'C', 'text' => 'Berdoa', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Gotong royong'],
                ]
            ],
            [
                'text' => '12) Pemimpin mendorong bawahan berani inisiatif & bertanggungjawab, pola ini …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Idealis & kharismatik'],
                    ['label' => 'B', 'text' => 'Tut Wuri Handayani', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Ing Ngarsa Sung Tulada'],
                    ['label' => 'D', 'text' => 'Ing Madya Mangun Karsa'],
                ]
            ],
            [
                'text' => '13) Presiden RI ke-3 adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Susilo Bambang Yudhoyono'],
                    ['label' => 'B', 'text' => 'B.J. Habibie'],
                    ['label' => 'C', 'text' => 'Megawati Soekarno Putri', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Abdurrahman Wahid'],
                ]
            ],
            [
                'text' => '14) Menteri BUMN Kabinet Indonesia Bersatu II adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Hatta Rajasa'],
                    ['label' => 'B', 'text' => 'Sri Mulyani'],
                    ['label' => 'C', 'text' => 'Dahlan Iskan', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Andi Mallarangeng'],
                ]
            ],
            [
                'text' => '15) Nama kabinet periode Ir. Joko Widodo adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Indonesia Bersatu'],
                    ['label' => 'B', 'text' => 'Gotong Royong'],
                    ['label' => 'C', 'text' => 'Pembangunan'],
                    ['label' => 'D', 'text' => 'Kerja', 'is_correct' => true],
                ]
            ],
            [
                'text' => '16) “Cinta tanah air” merupakan butir Pancasila sila …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Ketuhanan YME'],
                    ['label' => 'B', 'text' => 'Persatuan Indonesia', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Keadilan Sosial'],
                    ['label' => 'D', 'text' => 'Kemanusiaan yang adil & beradab'],
                ]
            ],
            [
                'text' => '17) Bapak Pembangunan adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Soekarno'],
                    ['label' => 'B', 'text' => 'Soeharto', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Moh. Hatta'],
                    ['label' => 'D', 'text' => 'Try Sutrisno'],
                ]
            ],
            [
                'text' => '18) Pasal UUD tentang bendera yang tidak pernah diamandemen adalah …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Pasal 1'],
                    ['label' => 'B', 'text' => 'Pasal 35', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Pasal 21'],
                    ['label' => 'D', 'text' => 'Pasal 28'],
                ]
            ],
            [
                'text' => '19) Bahasa negara adalah Bahasa Indonesia terdapat pada …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Pasal 34'],
                    ['label' => 'B', 'text' => 'Pasal 35'],
                    ['label' => 'C', 'text' => 'Pasal 36', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Pasal 37'],
                ]
            ],
            [
                'text' => '20) Lambang negara Garuda Pancasila ada dalam …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Pasal 36'],
                    ['label' => 'B', 'text' => 'Pasal 36A', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Pasal 36B'],
                    ['label' => 'D', 'text' => 'Pasal 36C'],
                ]
            ],
        ];

        foreach ($kewarganegaraanQuestions as $q) {
            $insertQuestion($kewarganegaraanId, $q);
        }

        // =================================
        // TEST 3: Angka Dalam Cerita (20 soal)
        // =================================
        $angkaDalamCeritaId = (string) Str::uuid();
        DB::table('tests')->insert([
            'id'                   => $angkaDalamCeritaId,
            'user_id'              => null,
            'title'                => 'Tes Angka Dalam Cerita',
            'description'          => 'Tes Angka Dalam Cerita',
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        $ceritaQuestions = [
            [
                'text' => '1) Dengan 4 liter bensin mobil menempuh 32 km. Jika menempuh 64 km perlu …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '5 liter'],
                    ['label' => 'B', 'text' => '6 liter'],
                    ['label' => 'C', 'text' => '7 liter'],
                    ['label' => 'D', 'text' => '8 liter', 'is_correct' => true],
                ]
            ],
            [
                'text' => '2) Roda pertama 2 putaran = roda kedua 5 putaran. Jika roda pertama 6 kali?',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '11 kali'],
                    ['label' => 'B', 'text' => '13 kali'],
                    ['label' => 'C', 'text' => '15 kali', 'is_correct' => true],
                    ['label' => 'D', 'text' => '17 kali'],
                ]
            ],
            [
                'text' => '3) 22 anak suka membaca, 28 suka musik, 20 suka keduanya. Total anak …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '30 anak'],
                    ['label' => 'B', 'text' => '40 anak'],
                    ['label' => 'C', 'text' => '50 anak', 'is_correct' => true],
                    ['label' => 'D', 'text' => '60 anak'],
                ]
            ],
            [
                'text' => '4) Susi punya 12 kelereng, menang 3, kalah 6. Sisa …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '21 kelereng'],
                    ['label' => 'B', 'text' => '3 kelereng'],
                    ['label' => 'C', 'text' => '9 kelereng', 'is_correct' => true],
                    ['label' => 'D', 'text' => '15 kelereng'],
                ]
            ],
            [
                'text' => '5) Usia Hasyim sekarang 15 th, Dwi sekarang 15 th. Usia Dwi 5 tahun lagi …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '3 tahun'],
                    ['label' => 'B', 'text' => '4 tahun'],
                    ['label' => 'C', 'text' => '5 tahun'],
                    ['label' => 'D', 'text' => '20 tahun', 'is_correct' => true],
                ]
            ],
            [
                'text' => '6) 8.100 ikan baik = 90%. Total tangkapan …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '8.900 ekor'],
                    ['label' => 'B', 'text' => '9.100 ekor', 'is_correct' => true],
                    ['label' => 'C', 'text' => '8.800 ekor'],
                    ['label' => 'D', 'text' => '9.000 ekor'],
                ]
            ],
            [
                'text' => '7) Luas dinding 13 × 4 m, biaya 4.500/m². Total biaya …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Rp.204.000'],
                    ['label' => 'B', 'text' => 'Rp.216.000', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Rp.223.000'],
                    ['label' => 'D', 'text' => 'Rp.234.000'],
                ]
            ],
            [
                'text' => '8) 6 × 6 × t = 18 × 18. Nilai t …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '9', 'is_correct' => true],
                    ['label' => 'B', 'text' => '98'],
                    ['label' => 'C', 'text' => '54'],
                    ['label' => 'D', 'text' => '108'],
                ]
            ],
            [
                'text' => '9) 18 anak, 11 bawa balap, 8 bawa sedan, 5 tidak bawa. Bawa keduanya …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '1 anak'],
                    ['label' => 'B', 'text' => '6 anak', 'is_correct' => true],
                    ['label' => 'C', 'text' => '12 anak'],
                    ['label' => 'D', 'text' => '14 anak'],
                ]
            ],
            [
                'text' => '10) Sarah terima Rp50.000. Sisa uang …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Rp.15.000'],
                    ['label' => 'B', 'text' => 'Rp.7.500'],
                    ['label' => 'C', 'text' => 'Rp.10.500', 'is_correct' => true],
                    ['label' => 'D', 'text' => 'Rp.12.000'],
                ]
            ],
            [
                'text' => '11) Jika r/3 genap & r/6 ganjil, nilai r …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '60'],
                    ['label' => 'B', 'text' => '18'],
                    ['label' => 'C', 'text' => '12'],
                    ['label' => 'D', 'text' => '24', 'is_correct' => true],
                ]
            ],
            [
                'text' => '12) A habis dibagi 30 & 35. Maka A juga habis dibagi …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '8'],
                    ['label' => 'B', 'text' => '11'],
                    ['label' => 'C', 'text' => '21', 'is_correct' => true],
                    ['label' => 'D', 'text' => '65'],
                ]
            ],
            [
                'text' => '13) Harga 18 baju Rp540.000. Harga 2,5 lusin …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => 'Rp1.000.000'],
                    ['label' => 'B', 'text' => 'Rp900.000', 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Rp800.000'],
                    ['label' => 'D', 'text' => 'Rp750.000'],
                ]
            ],
            [
                'text' => '14) Jumlah barang 24, meja = 3 × lemari. Jumlah meja …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '16 meja'],
                    ['label' => 'B', 'text' => '21 meja'],
                    ['label' => 'C', 'text' => '18 meja', 'is_correct' => true],
                    ['label' => 'D', 'text' => '20 meja'],
                ]
            ],
            [
                'text' => '15) x dibagi n → 63.000, tambah 1 orang → 52.500. Nilai x …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '300.000'],
                    ['label' => 'B', 'text' => '315.000'],
                    ['label' => 'C', 'text' => '350.000', 'is_correct' => true],
                    ['label' => 'D', 'text' => '400.000'],
                ]
            ],
            [
                'text' => '16) Balap mobil 10 km dalam 6 menit. Kecepatan …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '110 km/jam'],
                    ['label' => 'B', 'text' => '100 km/jam', 'is_correct' => true],
                    ['label' => 'C', 'text' => '90 km/jam'],
                    ['label' => 'D', 'text' => '60 km/jam'],
                ]
            ],
            [
                'text' => '17) Kebun 16×12 m, jalan 3 m keliling. Luas jalan …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '93'],
                    ['label' => 'B', 'text' => '168'],
                    ['label' => 'C', 'text' => '204', 'is_correct' => true],
                    ['label' => 'D', 'text' => '186'],
                ]
            ],
            [
                'text' => '18) Tito maju 8 m, mundur 4 m. Jarak dari semula …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '2 m'],
                    ['label' => 'B', 'text' => '3 m'],
                    ['label' => 'C', 'text' => '4 m', 'is_correct' => true],
                    ['label' => 'D', 'text' => '5 m'],
                ]
            ],
            [
                'text' => '19) Pesawat 3 km dalam 15 dtk. Kecepatan …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '440 km/jam'],
                    ['label' => 'B', 'text' => '520 km/jam'],
                    ['label' => 'C', 'text' => '600 km/jam', 'is_correct' => true],
                    ['label' => 'D', 'text' => '720 km/jam'],
                ]
            ],
            [
                'text' => '20) Najib jalan 5 jam 6 km/jam, pulang 3 jam motor. Rata-rata …',
                'type' => 'multiple_choice',
                'points' => 1,
                'choices' => [
                    ['label' => 'A', 'text' => '5 km/jam'],
                    ['label' => 'B', 'text' => '8 km/jam'],
                    ['label' => 'C', 'text' => '10 km/jam', 'is_correct' => true],
                    ['label' => 'D', 'text' => '12 km/jam'],
                ]
            ],
        ];

        foreach ($ceritaQuestions as $q) {
            $insertQuestion($angkaDalamCeritaId, $q);
        }
    }
}
