<div>
    @props([
    /**
     * @var \App\Models\Question $question
     *  - fields: id, question_text, type, points
     *  - relation: choices() -> hasMany(QuestionChoice) { choice_label, choice_text, is_correct }
     *
     * @var mixed $userAnswer
     *  - multiple_choice / true_false : string pilihan (choice_label), contoh: 'A' atau 'true'
     *  - essay                       : string (teks)
     *  - fill_in_blank               : array string, contoh: ['jawaban1', 'jawaban2']
     *  - matching                    : array pasangan, contoh: [['left'=>'A', 'right'=>'1'], ...]
     *
     * @var bool $showCorrect : tampilkan kunci (default true)
     */
    'question',
    'userAnswer' => null,
    'showCorrect' => true,
])

    @php
        $type = $question->type;
        $choices = collect($question->choices ?? []);
        $hasAutoKey = in_array($type, ['multiple_choice', 'true_false']) && $choices->isNotEmpty();

        // Ambil label pilihan yang benar untuk MCQ/TF
        $correctLabels = $hasAutoKey ? $choices->where('is_correct', true)->pluck('choice_label')->values()->all() : [];

        $isCorrect = null;
        if ($hasAutoKey) {
            // Untuk MCQ/TF — userAnswer string, cek ada di label benar
            $isCorrect = in_array((string) $userAnswer, $correctLabels, true);
        }

        // Util tampilan
        $chip = fn($status) => match ($status) {
            'correct'
                => 'inline-flex items-center rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
            'wrong'
                => 'inline-flex items-center rounded-full bg-rose-100 px-2 py-1 text-xs font-medium text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
            default
                => 'inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 dark:bg-neutral-800 dark:text-neutral-300',
        };
    @endphp

    <div
        class="rounded-2xl border border-gray-200 bg-white shadow-sm p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-800">
        {{-- Header Soal --}}
        <div class="flex items-start justify-between gap-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-800 dark:text-neutral-100">
                {!! nl2br(e($question->question_text)) !!}
            </h3>

            {{-- Chip status --}}
            @if (!is_null($isCorrect))
                <span class="{{ $chip($isCorrect ? 'correct' : 'wrong') }}">
                    {{ $isCorrect ? 'Benar' : 'Salah' }}
                </span>
            @else
                <span class="{{ $chip('pending') }}">
                    {{ in_array($type, ['essay', 'fill_in_blank', 'matching']) ? 'Menunggu penilaian' : '—' }}
                </span>
            @endif
        </div>

        {{-- Body: jawaban & opsi --}}
        <div class="mt-4 space-y-4 text-sm text-gray-700 dark:text-neutral-200">

            {{-- MULTIPLE CHOICE / TRUE FALSE --}}
            @if (in_array($type, ['multiple_choice', 'true_false']))
                <ul class="space-y-2">
                    @foreach ($choices as $opt)
                        @php
                            $isUser = (string) $userAnswer === (string) $opt->choice_label;
                            $isKey = (bool) $opt->is_correct;

                            // state warna tiap opsi
                            $cls = 'border bg-white dark:bg-neutral-900';
                            if ($isUser && $isKey) {
                                $cls =
                                    'border-emerald-300 bg-emerald-50 dark:border-emerald-700/40 dark:bg-emerald-900/20';
                            } elseif ($isUser && !$isKey) {
                                $cls = 'border-rose-300 bg-rose-50 dark:border-rose-700/40 dark:bg-rose-900/20';
                            } elseif (!$isUser && $isKey && $showCorrect) {
                                $cls =
                                    'border-emerald-200 bg-emerald-50/60 dark:border-emerald-700/30 dark:bg-emerald-900/10';
                            } else {
                                $cls = 'border-gray-200 bg-gray-50 dark:border-neutral-800 dark:bg-neutral-800/50';
                            }
                        @endphp

                        <li class="flex items-start gap-3 rounded-xl px-3 py-2 border {{ $cls }}">
                            <div class="mt-0.5 shrink-0">
                                <span
                                    class="inline-flex size-6 items-center justify-center rounded-md
                @if ($isUser && $isKey) bg-emerald-500 text-white
                @elseif($isUser && !$isKey)
                  bg-rose-500 text-white
                @elseif($isKey && $showCorrect)
                  bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                @else
                  bg-gray-200 text-gray-700 dark:bg-neutral-700 dark:text-neutral-200 @endif
              ">
                                    {{ $opt->choice_label }}
                                </span>
                            </div>

                            <div class="min-w-0">
                                <div class="font-medium">
                                    {!! nl2br(e($opt->choice_text)) !!}
                                </div>

                                <div class="mt-1 text-xs text-gray-500 dark:text-neutral-400">
                                    @if ($isUser && $isKey)
                                        Jawaban kamu
                                        <span
                                            class="ml-1 rounded px-1.5 py-0.5 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">benar</span>
                                    @elseif($isUser && !$isKey)
                                        Jawaban kamu
                                        <span
                                            class="ml-1 rounded px-1.5 py-0.5 bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">salah</span>
                                    @elseif(!$isUser && $isKey && $showCorrect)
                                        Kunci jawaban
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{-- ESSAY --}}
            @if ($type === 'essay')
                <div
                    class="rounded-xl border border-gray-200 bg-gray-50 p-3 dark:border-neutral-800 dark:bg-neutral-800/60">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400 mb-1">Jawaban kamu
                    </div>
                    <div class="whitespace-pre-wrap">{{ $userAnswer }}</div>
                </div>
            @endif

            {{-- FILL IN BLANK --}}
            @if ($type === 'fill_in_blank')
                @php $answers = is_array($userAnswer) ? $userAnswer : (array) $userAnswer; @endphp
                <div class="space-y-2">
                    @foreach ($answers as $i => $ans)
                        <div
                            class="flex items-start gap-2 rounded-lg border border-gray-200 bg-gray-50 p-2 dark:border-neutral-800 dark:bg-neutral-800/60">
                            <span
                                class="inline-flex size-6 items-center justify-center rounded-md bg-gray-200 text-gray-700 text-xs dark:bg-neutral-700 dark:text-neutral-200">{{ $i + 1 }}</span>
                            <div class="min-w-0">{{ $ans }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- MATCHING --}}
            @if ($type === 'matching')
                @php
                    $pairs = is_array($userAnswer) ? $userAnswer : [];
                @endphp
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-neutral-800">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-800">
                        <thead class="bg-gray-50 dark:bg-neutral-800/60">
                            <tr>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                    Kiri</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                    Kanan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                            @forelse($pairs as $p)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-neutral-200">
                                        {{ $p['left'] ?? '' }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-neutral-200">
                                        {{ $p['right'] ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-3 text-sm text-gray-500 dark:text-neutral-400">
                                        Belum ada jawaban.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

        {{-- Footer poin (opsional) --}}
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-neutral-400">
            <div>Tipe: <span
                    class="font-medium text-gray-700 dark:text-neutral-200">{{ str_replace('_', ' ', $type) }}</span>
            </div>
            <div>Poin soal: <span
                    class="font-medium text-gray-700 dark:text-neutral-200">{{ $question->points }}</span></div>
        </div>
    </div>

</div>
