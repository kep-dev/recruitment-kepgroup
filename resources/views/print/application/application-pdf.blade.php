<!DOCTYPE html>
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

</html>
