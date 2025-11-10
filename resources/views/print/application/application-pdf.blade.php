{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Resume</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 40px;
        }

        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #f1f1f1;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .logo {
            width: 120px;
            height: 60px;
            border: 1px solid #ccc;
            /* slot logo */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10pt;
            color: #777;
            margin-right: 20px;
        }

        .title {
            font-size: 20pt;
            font-weight: bold;
            color: #00695c;
        }

        h3 {
            margin-top: 25px;
            margin-bottom: 8px;
            color: #00695c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 6px 8px;
        }

        table th {
            background: #00695c;
            color: white;
            text-align: center;
        }

        .section-title {
            border-bottom: 2px solid #ffcc00;
            font-weight: bold;
            padding-bottom: 4px;
        }

        .highlight {
            background: #f8f8f8;
            font-weight: bold;
        }

        .rata-rata {
            background: #fdd;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">Logo Anda</div>
        <div class="title">RESUME</div>
    </div>

    <!-- BIODATA -->
    <div class="section-title">BIODATA</div>
    <table>
        <tr>
            <td class="highlight">Nama</td>
            <td>{{ $record->user->name }}</td>
        </tr>
        <tr>
            <td class="highlight">Tempat, Tanggal Lahir</td>
            <td>{{ $record->user->applicant->date_of_birth }}</td>
        </tr>
        <tr>
            <td class="highlight">Alamat</td>
            <td>{{ $record->user->applicant->city . ', ' . $record->user->applicant->province }}</td>
        </tr>
        <tr>
            <td class="highlight">No WhatsApp</td>
            <td>{{ $record->user->applicant->phone_number }}</td>
        </tr>
        <tr>
            <td class="highlight">Catatan</td>
            <td></td>
        </tr>
    </table>
    <br>

    <!-- DATA AKADEMIK -->
    <div class="section-title">DATA AKADEMIK | PENDIDIKAN TERAKHIR</div>
    <small>(Terverifikasi melalui <a href="https://pddikti.kemdikbud.go.id">pddikti</a>)</small>
    <table>
        <tr>
            <td class="highlight">Perguruan Tinggi</td>
            <td>{{ $record->user->applicant->latestEducation->university }}</td>
        </tr>
        <tr>
            <td class="highlight">IPK</td>
            <td>{{ $record->user->applicant->latestEducation->gpa }}</td>
        </tr>
        <tr>
            <td class="highlight">Universitas</td>
            <td>{{ $record->user->applicant->latestEducation->university }}</td>
        </tr>
        <tr>
            <td class="highlight">Program Studi</td>
            <td>{{ $record->user->applicant->latestEducation->education_level . ' ' . $record->user->applicant->latestEducation->major }}
            </td>
        </tr>
        <tr>
            <td class="highlight">Tahun Lulus</td>
            <td>{{ $record->user->applicant->latestEducation->graduation_year }}</td>
        </tr>
    </table>
    <br>

    <!-- TES POTENSI AKADEMIK -->
    <div class="section-title">TES POTENSI AKADEMIK</div>
    <table>
        <tr>
            <th>JENIS SOAL</th>
            <th>NILAI MINIMUM</th>
            <th>NILAI HASIL TES</th>
            <th>KETERANGAN</th>
        </tr>
        @foreach ($record->applicantTests->attempts as $attempt)
            <tr>
                <td>{{ $attempt->jobVacancyTestItem->test->title }}</td>
                <td align="center">{{ $attempt->jobVacancyTestItem->minimum_score }}</td>
                <td align="center">60</td>
                <td>diatas nilai minimum</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"></td>
            <td class="rata-rata" colspan="2">Rata-rata: 66</td>
        </tr>
    </table>

</body>

</html> --}}

<!DOCTYPE html>
<html lang="en" class="minimal-theme">
@use('Carbon\Carbon')

<head>
    <meta charset="utf-8">
    <title>{{ $record->user->name }} - {{ $record->jobVacancy->title }}</title>

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
            size: A4
        }

        table,
        th,
        td {
            border: 1px solid rgb(201, 201, 201);
            border-collapse: collapse;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
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
        <div class="title mt-3">RESUME</div>

        <div class="section-title section-border mt-2">BIODATA</div>
        <table id="example" class="table borderless" style="font-size:12px; border-color:rgba(255, 255, 255, 0)">
            <tbody id="data">
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Nama</td>
                    <td>: {{ $record->user->name }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Tempat, Tanggal Lahir</td>
                    <td>: {{ $record->user->applicant->place_of_birth }}, {{ $record->user->applicant->date_of_birth }}
                        |
                        {{ (int) Carbon::parse($record->user->applicant->date_of_birth)->diffInYears(Carbon::now()) }}
                        Tahun</td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Alamat</td>
                    <td>:
                        {{ $record->user?->applicant?->province?->name .
                            ', ' .
                            $record->user?->applicant?->district?->name .
                            ', ' .
                            $record->user?->applicant?->regency?->name .
                            ', ' .
                            $record->user?->applicant?->village?->name .
                            ', ' .
                            $record->user?->applicant?->address_line }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">No Whatsapp</td>
                    <td>: {{ $record->user?->applicant?->phone_number }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Catatan</td>
                    <td>: Catatan Resume</td>
                </tr>
            </tbody>
        </table>

        <div class="section-border mt-2">
            <div>
                <span style="font-weight: bold; color: rgb(6, 105, 94)">DATA AKADEMIK</span>
                <span style="font-size: 12px; color: rgb(0, 0, 0)">(Terverifikasi melalui
                    https://pisn.kemdiktisaintek.go.id dan https://pddikti.kemdiktisaintek.go.id)</span>
            </div>
        </div>
        <table id="example" class="table borderless" style="font-size:12px; border-color:rgba(255, 255, 255, 0)">
            <tbody id="data">
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Perguruan Tinggi</td>
                    <td>: {{ $record->user->applicant->latestEducation->university }} </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">NIS/NIM</td>
                    <td>: {{ $record->user->applicant->latestEducation->main_number }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">IPK</td>
                    <td>: {{ $record->user->applicant->latestEducation->gpa }} </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Program Studi</td>
                    <td>: {{ $record->user->applicant->latestEducation->education_level }} -
                        {{ $record->user->applicant->latestEducation->major }} </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Nomor Ijazah</td>
                    <td>: {{ $record->user->applicant->latestEducation->certificate_number }}
                        {{ $record->user->applicant->latestEducation->certificate_number == null ? 'Belum Lulus' : '' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="section-title section-border mt-2">TES POTENSI AKADEMIK</div>
        <table id="example" class="table table-bordered" style="font-size:12px;">
            <thead>
                <tr class="text-center" style="color: rgb(255, 255, 255); background-color: rgb(6, 105, 94)">
                    <th>JENIS SOAL</th>
                    <th>NILAI MINIMUM</th>
                    <th>NILAI HASIL TES</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>
            <tbody id="data">
                @foreach ($record->applicantTests->attempts as $attempt)
                    <tr>
                        <td>{{ $attempt->jobVacancyTestItem->test->title }}</td>
                        <td class="text-center"><mark>{{ $attempt->jobVacancyTestItem->minimum_score }}</mark></td>
                        <td class="text-center" style="font-weight: bold">{{ $attempt->score }}</td>
                        <td>{{ $attempt->score > $attempt->jobVacancyTestItem->minimum_score ? 'diatas nilai minimum' : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title section-border mt-2">PRE-MEDICAL CHECK UP SUMMARY</div>
        <table id="example" class="table borderless" style="font-size:12px; border-color:rgba(255, 255, 255, 0)">
            <tbody id="data">
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Medical record Number</td>
                    <td>: 036/CFK-Klinik/P-MCU/VIII/2025</td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Tangal MCU</td>
                    <td>: {{ $record->preMedicalSessionApplication->reviewed_at }} </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Golongan Darah</td>
                    <td>: {{ $record->preMedicalSessionApplication->preMedicalResult->preMedicalPhysical->blood_type }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Hasil</td>
                    <td>: {{ $record->preMedicalSessionApplication->preMedicalResult->overall_status }} </td>
                </tr>
                <tr>
                    <td style="width: 30%; background-color: #d3d3d3">Keterangan</td>
                    <td>: {!! $record->preMedicalSessionApplication->preMedicalResult->overall_note !!} </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
        <div class="section-title section-border mt-5">TES WAWANCARA</div>
        <table id="example" class="table table-bordered" style="font-size:12px;">
            <thead>
                <tr class="text-center" style="color: rgb(255, 255, 255); background-color: rgb(6, 105, 94)">
                    <th>URAIAN</th>
                    <th>PENGUJI 1</th>
                    <th>PENGUJI 2</th>
                    <th>PENGUJI 3</th>
                </tr>
            </thead>
            <tbody id="data">
                <tr>
                    <td class="text-center" style="vertical-align: middle; font-weight: bold" rowspan="4">Pengetahuan
                        Teknis/akademik</td>
                    <td><input type="checkbox" /> Kurang</td>
                    <td><input type="checkbox" /> Kurang</td>
                    <td><input type="checkbox" /> Kurang</td>
                </tr>
                <tr>
                    <td><input type="checkbox" /> Cukup</td>
                    <td><input type="checkbox" /> Cukup</td>
                    <td><input type="checkbox" /> Cukup</td>
                </tr>
                <tr>
                    <td><input type="checkbox" /> Baik</td>
                    <td><input type="checkbox" /> Baik</td>
                    <td><input type="checkbox" /> Baik</td>
                </tr>
                <tr>
                    <td><input type="checkbox" /> Sangat Baik</td>
                    <td><input type="checkbox" /> Sangat Baik</td>
                    <td><input type="checkbox" /> Sangat Baik</td>
                </tr>
            </tbody>
        </table>

    </section>

</body>

</html>
