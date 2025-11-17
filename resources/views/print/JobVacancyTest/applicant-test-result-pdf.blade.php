<!DOCTYPE html>
<html lang="en" class="minimal-theme">
@use('Carbon\Carbon')

<head>
    <meta charset="utf-8">
    <title>{{ $record->name }}</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    {{-- @include('include.style') --}}

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href={{ asset('css/paper.css') }}>

    <!-- Set page size here: A5, A4 or A3 -->
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }


        table {
            width: 100%;
            table-layout: fixed;
        }

        th,
        td {
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }

        .borderless th,
        .borderless td {
            border: none;
        }

        .title {
            font-size: 20pt;
            font-weight: bold;
            color: #014e45;
        }

        .section-title {
            font-weight: bold;
            padding-bottom: 4px;
            color: rgb(6, 105, 94);
        }

        .section-border {
            border-bottom: 2px solid #ffcc00;
        }

        .rata-rata {
            background: #fdd;
            font-weight: bold;
        }

        .print-block {
            page-break-inside: avoid;
            margin-top: 8px;
        }
    </style>
    <!-- Set also "landscape" if you need -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        {{-- <img class="logo-icon mx-auto my-auto d-block img-fluid" style="height: 75px" src={{ asset($logoCompanyUrl) }} alt="logo icon"> --}}
        <div class="title mt-3">DAFTAR TES</div>
        <div class="section-title section-border mt-2">{{ Str::upper($record->name) }}</div>

        @php
            // Tentukan berapa kolom tes per tabel
            $chunkSize = 6; // silakan ubah: 4–8 biasanya aman untuk A4 portrait

            $testItems = $record->jobVacancyTestItems->sortBy('order')->values();
            $testChunks = $testItems->chunk($chunkSize);

            // Helper kecil untuk ambil skor per item agar selalu sejajar
            $getScore = function ($applicantTest, $itemId) {
                $attempt = $applicantTest->attempts->firstWhere('job_vacancy_test_item_id', $itemId);
                return optional($attempt)->score ?? '-';
            };
        @endphp

        @foreach ($testChunks as $chunkIndex => $chunk)
            <div class="print-block">
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr class="text-center" style="color:#fff; background-color: rgb(6, 105, 94);">
                            <th>NAMA</th>
                            <th>PENDIDIKAN TERAKHIR</th>
                            <th>NO. TELP</th>
                            @foreach ($chunk as $jobVacancyTestItem)
                                <th>
                                    {{ Str::upper($jobVacancyTestItem->test->title) }}
                                    @if ($testChunks->count() > 1)
                                        {{-- penanda kelompok kolom jika banyak halaman --}}
                                        <small>(Bagian {{ $chunkIndex + 1 }})</small>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->applicantTests as $applicantTest)
                            <tr>
                                <td>{{ Str::upper($applicantTest->application->user->name) }}</td>
                                <td>{{ $applicantTest->application?->user?->applicant?->latestEducation?->university }}
                                </td>
                                <td>{{ $applicantTest->application->user->applicant->phone_number }}</td>

                                @foreach ($chunk as $jobVacancyTestItem)
                                    <td>{{ $getScore($applicantTest, $jobVacancyTestItem->id) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

    </section>
</body>

</html>
