<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Hasil Psikotest {{ $attempt->applicantTest->application->user->name ?? '-' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .small {
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Hasil Laporan Psikotest</h2>
        <div class="small">Nama: {{ $attempt->applicantTest->application->user->name }} &middot; Attempt #:
            {{ $attempt->attempt_no ?? '-' }}</div>
    </div>

    <div class="section">
        <strong>Calon Kandidat</strong>
        <div class="small">
            {{ optional($attempt->applicantTest)->application ? optional($attempt->applicantTest->application->user)->name : '-' }}
        </div>
        <div class="small">Started: {{ $attempt->started_at }} Completed: {{ $attempt->completed_at }}</div>
    </div>

    <div class="section">
        <strong>Summary</strong>
        <table>
            <tr>
                <th>Score</th>
                <th>Status</th>
                <th>Ended Reason</th>
            </tr>
            <tr>
                <td>{{ $attempt->score ?? '-' }}</td>
                <td>{{ $attempt->status ?? '-' }}</td>
                <td>{{ $attempt->ended_reason ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <strong>Answers</strong>
        <table>
            <tr>
                <th>#</th>
                {{-- <th>Question</th> --}}
                <th>Jawaban</th>
            </tr>
            @foreach ($attempt->answers as $i => $answer)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    {{-- <td>{{ optional($answer->question)->title ?? (optional($answer->question)->text ?? '-') }}</td> --}}
                    <td>{{ optional($answer->option)->label }}. {{ optional($answer->option)->statement }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- <div class="section">
        <strong>Characteristics</strong>
        <table>
            <tr>
                <th>Characteristic</th>
                <th>Value</th>
            </tr>
            @foreach ($attempt->characteristics as $c)
                <tr>
                    <td>{{ optional($c->characteristic)->name ?? (optional($c)->name ?? '-') }}</td>
                    <td>{{ $c->value ?? ($c->score ?? '-') }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="section">
        <strong>Aspects</strong>
        <table>
            <tr>
                <th>Aspect</th>
                <th>Value</th>
            </tr>
            @foreach ($attempt->aspects as $a)
                <tr>
                    <td>{{ optional($a->aspect)->name ?? (optional($a)->name ?? '-') }}</td>
                    <td>{{ $a->value ?? ($a->score ?? '-') }}</td>
                </tr>
            @endforeach
        </table>
    </div> --}}

</body>

</html>
