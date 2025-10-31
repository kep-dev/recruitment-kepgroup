@use('App\Enums\QuestionType')
<div class="max-w-[125rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto" x-data="examGuard()" x-init="window.examGuard = this;
init()"
    x-on:keydown.window="blockKeys($event)">
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-12 lg:col-span-12order-2 lg:order-1">
            <div class="max-w-full mx-auto space-y-5">
                {{-- Header / Progress --}}
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-800 dark:text-neutral-100">
                            {{ $attempt->test->title ?? '—' }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">
                            Soal {{ $index + 1 }} dari {{ $attemptQuestions->count() }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2" wire:ignore>

                        <div class="mt-3 flex items-center gap-3 rounded-2xl shadow-sm border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 dark:border-neutral-800 dark:bg-neutral-800/60 dark:text-neutral-100"
                            data-deadline="{{ \Illuminate\Support\Carbon::parse($attempt->deadline_at)->toIso8601String() }}"
                            data-finished-text="Waktu habis">
                            <div class="flex items-baseline gap-2">
                                <span class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Sisa
                                    waktu</span>
                                <span class="js-countdown text-lg font-bold tabular-nums">--:--:--</span>
                            </div>

                            {{-- Status chip yg akan diganti warnanya via JS --}}
                            <span
                                class="js-countdown-chip inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                         bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                Aman
                            </span>
                        </div>
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-neutral-100">
                                <div class="js-countdown-progress h-2 rounded-full" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigator Nomor Soal --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:bg-neutral-900 dark:border-neutral-800">
                    <div class="text-sm font-medium text-gray-700 mb-3 dark:text-neutral-200">Navigasi Soal</div>
                    <div class="grid grid-cols-10 sm:grid-cols-12 md:grid-cols-15 gap-2">
                        @foreach ($attemptQuestions as $i => $aq)
                            @php
                                $qid = $aq->question->id;
                                $answered =
                                    array_key_exists($qid, $answers) &&
                                    $answers[$qid] !== null &&
                                    $answers[$qid] !== '' &&
                                    $answers[$qid] !== [];
                                $isActive = $i === $index;
                            @endphp
                            <button type="button" wire:click="selectIndex({{ $i }})"
                                class="w-full aspect-square rounded-lg text-sm font-semibold
                      @if ($isActive) bg-gray-900 text-white dark:bg-white dark:text-neutral-900
                      @elseif($answered)
                        bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-400
                      @else
                        bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700 @endif
                ">
                                {{ $i + 1 }}
                            </button>
                        @endforeach
                    </div>
                </div>

                @php
                    $aq = $this->currentAttemptQuestion;
                    $q = $this->currentQuestion;
                @endphp

                @if ($q)
                    {{-- Card Soal --}}
                    <div
                        class="rounded-2xl border border-gray-200 bg-white shadow-sm p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="text-base md:text-lg font-semibold text-gray-800 dark:text-neutral-100">
                                {!! $q->question_text !!}
                            </h3>
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 dark:bg-neutral-800 dark:text-neutral-300">
                                {{ str_replace('_', ' ', $q->type->getLabel()) }} • {{ $q->points }} poin
                            </span>
                        </div>

                        <div class="mt-4 space-y-4 text-sm text-gray-700 dark:text-neutral-200">
                            {{-- MULTIPLE CHOICE --}}
                            @if ($q->type === QuestionType::multiple_choice)
                                @php
                                    // 1) Sort choices by label naturally: A,B,C,D,...
                                    $choices = collect($q->choices ?? [])
                                        ->sortBy('choice_label', SORT_NATURAL | SORT_FLAG_CASE)
                                        ->values();

                                    // 2) Ambil jawaban yang sudah tersimpan (jika ada)
                                    $selected = $answers[$q->id] ?? null;
                                @endphp

                                {{-- Tampilkan stem/soal dari RichText Filament (HTML apa adanya) --}}
                                <div class="mb-4">
                                    <div class="richtext-content">
                                        {!! $q->question_html ?? ($q->question ?? '') !!}
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    @foreach ($choices as $opt)
                                        <label
                                            class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-3 cursor-pointer dark:border-neutral-800 dark:bg-neutral-800/60"
                                            wire:key="q{{ $q->id }}-{{ $opt->choice_label }}">
                                            <input type="radio" class="mt-1 shrink-0"
                                                id="answer-{{ $q->id }}-{{ $opt->choice_label }}"
                                                name="answer-{{ $q->id }}"
                                                wire:change="setAnswer('{{ $q->id }}', '{{ $opt->choice_label }}')"
                                                @checked($selected === $opt->choice_label) />

                                            <div class="min-w-0">
                                                <div class="font-medium">
                                                    <span
                                                        class="inline-flex size-6 items-center justify-center rounded-md bg-gray-200 text-gray-700 text-xs mr-2 dark:bg-neutral-700 dark:text-neutral-200">
                                                        {{ $opt->choice_label }}
                                                    </span>

                                                    {{-- Choice text dari RichText: render HTML (biar <p>, <img>, <ul> tampil) --}}
                                                    <span class="richtext-content align-middle">
                                                        {!! $opt->choice_text !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            {{-- TRUE/FALSE (gunakan choices label "true"/"false" atau "A/B" sesuai seed) --}}
                            @if ($q->type === QuestionType::true_false)
                                @php $selected = $answers[$q->id] ?? null; @endphp
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach ($q->choices ?? [] as $opt)
                                        <label
                                            class="flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-3 cursor-pointer dark:border-neutral-800 dark:bg-neutral-800/60">
                                            <input type="radio" class="shrink-0"
                                                id="answer-{{ $q->id }}-{{ $opt->choice_label }}"
                                                name="answer-{{ $q->id }}"
                                                wire:change="setAnswer('{{ $q->id }}', '{{ $opt->choice_label }}')"
                                                @checked($selected === $opt->choice_label) />
                                            <span class="font-medium">{{ ucfirst($opt->choice_text) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            {{-- ESSAY --}}
                            @if ($q->type === QuestionType::essay)
                                <div class="space-y-1">
                                    <label
                                        class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Jawaban
                                        kamu</label>
                                    <textarea
                                        class="w-full rounded-xl border border-gray-200 bg-white p-3 focus:outline-hidden focus:ring-2 focus:ring-gray-400 dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100"
                                        rows="6" wire:model.live.debounce.500ms="answers.{{ $q->id }}" placeholder="Tulis jawaban di sini..."
                                        x-ref="answer-{{ $q->id }}"></textarea>

                                    <div class="flex items-center gap-2">
                                        {{-- <button type="button"
                                            wire:click="setAnswer('{{ $q->id }}', $refs['answer-{{ $q->id }}'].value)"
                                            class="inline-flex items-center rounded-lg border border-transparent bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-100">
                                            Simpan Jawaban
                                        </button> --}}
                                    </div>
                                </div>
                            @endif

                            {{-- FILL IN BLANK (sementara: list input) --}}
                            @if ($q->type === QuestionType::fill_in_blank)
                                @php
                                    $vals = $answers[$q->id] ?? [''];
                                @endphp
                                <div class="space-y-2">
                                    @foreach ($vals as $i => $v)
                                        <div class="flex items-center gap-2">
                                            <input type="text"
                                                class="flex-1 rounded-lg border border-gray-200 bg-white p-2 dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100"
                                                wire:model.live.debounce.500ms="answers.{{ $q->id }}.{{ $i }}"
                                                placeholder="Isian {{ $i + 1 }}" />
                                            <button type="button"
                                                class="px-2 py-1 text-xs rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200"
                                                wire:click="$set('answers.{{ $q->id }}', {{ collect($vals)->except($i)->values()->toJson() }})">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                    <button type="button"
                                        class="rounded-md bg-gray-100 px-2 py-1 text-xs hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200"
                                        wire:click="$set('answers.{{ $q->id }}', {{ collect($vals)->push('')->values()->toJson() }})">
                                        + Tambah Isian
                                    </button>
                                </div>
                            @endif

                            {{-- MATCHING (sementara: tabel pasangan kiri-kanan) --}}
                            @if ($q->type === QuestionType::matching)
                                @php
                                    // Ambil semua pasangan dari choices (sesuai seeder: label=left, text=right)
                                    $choices = $q->choices ?? collect();
                                    $lefts = $choices->pluck('choice_label')->filter()->values(); // sisi kiri
                                    $rights = $choices->pluck('choice_text')->filter()->unique()->shuffle()->values(); // opsi kanan (diacak 1x)

                                    // Bentuk jawaban saat ini (answers[qid] = [{left:'', right:''}, ...]) agar sejajar dgn jumlah lefts
                                    $current = collect($answers[$q->id] ?? [])->map(
                                        fn($row) => ['left' => $row['left'] ?? '', 'right' => $row['right'] ?? ''],
                                    );

                                    // Sinkronkan jumlah baris sesuai jumlah "lefts"
                                    $rows = $lefts->map(function ($left, $i) use ($current) {
                                        $row = $current->get($i, ['left' => $left, 'right' => '']);
                                        $row['left'] = $left; // pastikan left sesuai dari DB
                                        return $row;
                                    });
                                @endphp
                                {{-- {{ $lefts }} --}}
                                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-neutral-800">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-800">
                                        <thead class="bg-gray-50 dark:bg-neutral-800/60">
                                            <tr>
                                                <th
                                                    class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                                    Kiri
                                                </th>
                                                <th
                                                    class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                                    Pasangkan dengan (kanan)
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody
                                            class="divide-y divide-gray-200 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                                            @foreach ($rows as $i => $row)
                                                <tr>
                                                    <td class="px-3 py-2 align-top">
                                                        <div class="flex items-center gap-2">
                                                            <span
                                                                class="inline-block rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 dark:bg-neutral-800 dark:text-neutral-200">
                                                                {{ $row['left'] }}
                                                            </span>
                                                            {{-- simpan "left" ke state agar saat submit tetap ada pasangan left->right --}}
                                                            <input type="hidden"
                                                                wire:model.defer="answers.{{ $q->id }}.{{ $i }}.left"
                                                                value="{{ $row['left'] }}">
                                                        </div>
                                                    </td>

                                                    <td class="px-3 py-2">
                                                        <select
                                                            class="w-full rounded-lg border border-gray-200 bg-white p-2 text-sm dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100"
                                                            wire:model.defer="answers.{{ $q->id }}.{{ $i }}.right">
                                                            <option value="">— pilih jawaban —</option>
                                                            @foreach ($rights as $opt)
                                                                <option value="{{ $opt }}">
                                                                    {{ $opt }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("answers.$q->id.$i.right")
                                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- (Opsional) tombol reset pilihan user untuk pertanyaan ini --}}
                                <div class="mt-2">
                                    <button type="button"
                                        class="rounded-md bg-gray-100 px-2 py-1 text-xs hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200"
                                        wire:click="$set('answers.{{ $q->id }}', {{ $lefts->map(fn($l) => ['left' => $l, 'right' => ''])->values()->toJson() }})">
                                        Reset Jawaban
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Footer aksi --}}
                        <div class="mt-5 flex flex-col lg:flex-row items-center justify-between gap-4">
                            <div class="text-xs text-gray-500 dark:text-neutral-400">
                                Soal {{ $index + 1 }} / {{ $attemptQuestions->count() }}
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="prev"
                                    class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-200">
                                    ← Sebelumnya
                                </button>
                                <button type="button" wire:click="next"
                                    class="inline-flex items-center rounded-lg border border-transparent bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800 focus:outline-hidden focus:ring-2 focus:ring-gray-400 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-100">
                                    Selanjutnya →
                                </button>
                                <button type="button"
                                    class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-200"
                                    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sign-out-alert"
                                    data-hs-overlay="#hs-sign-out-alert">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="hs-sign-out-alert"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
        tabindex="-1" aria-labelledby="hs-sign-out-alert-label">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-900">
                <div class="absolute top-2 end-2">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#hs-sign-out-alert">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    <!-- Icon -->
                    <span
                        class="mb-4 inline-flex justify-center items-center size-15.5 rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500 dark:bg-yellow-700 dark:border-yellow-600 dark:text-yellow-100">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                    </span>
                    <!-- End Icon -->

                    <h3 id="hs-sign-out-alert-label"
                        class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200">
                        Submit Test
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-500">
                        Apakah anda sudah yakin dengan jawaban anda? Anda yakin ingin melakukan submit?
                    </p>

                    <div class="mt-6 flex justify-center gap-x-4">
                        <button type="button" wire:click="submitAll"
                            @click="
                                window.examGuard?.disableUnloadGuard();
                                $wire.submitAll;
                            "
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                            Ya, Submit
                        </button>
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            data-hs-overlay="#hs-sign-out-alert">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-molecules.alerts.alert />

    <script>
        window.examAttemptId = "{{ $attempt->id }}"; // sesuaikan variabelnya
    </script>

    <script>
        /* ===== Global listener: submit dari Livewire → redirect tanpa dialog ===== */
        window.addEventListener('submitTest', (e) => {
            const url = e.detail?.url || '/';

            // Lepas guard 'beforeunload' terlebih dulu
            try {
                window.examGuardInstance?.disableUnloadGuard();
            } catch (_) {}

            // Beri 1 tick agar pelepasan listener diproses sebelum navigasi
            setTimeout(() => location.replace(url), 0);
        });

        /* ================== EXAM GUARD ================== */
        function examGuard() {
            return {
                // ---- state ----
                sessionKey: null,
                bc: null,
                isExamWindow: false,
                preventUnload: true,
                beforeUnloadHandler: null,

                // pelanggaran (contoh)
                focusViolations: 0,
                devtoolsViolations: 0,
                maxViolations: 5,

                /* ---------- init ---------- */
                init() {
                    // Simpan instance global untuk dipanggil di listener submit/end
                    window.examGuardInstance = this;

                    this.sessionKey = `exam_session_${window.examAttemptId || 'unknown'}`;
                    this.isExamWindow = (window.opener != null);

                    // ==== BroadcastChannel: cegah multi-window ====
                    this.bc = new BroadcastChannel(this.sessionKey);
                    this.bc.onmessage = (e) => {
                        if (e.data === 'EXAM_ALREADY_ACTIVE' && !this.isExamWindow) {
                            alert('Tes sudah aktif di jendela lain. Jendela ini akan ditutup.');
                            window.close();
                        }
                    };
                    this.bc.postMessage('EXAM_ALREADY_ACTIVE');

                    // ==== Tandai sesi aktif hanya pada jendela ujian ====
                    if (this.isExamWindow) {
                        localStorage.setItem(this.sessionKey, String(Date.now()));
                        // housekeeping: tidak memicu dialog karena tanpa e.returnValue
                        window.addEventListener('beforeunload', () => {
                            localStorage.removeItem(this.sessionKey);
                            try {
                                this.bc.close();
                            } catch (_) {}
                        });
                    } else {
                        if (localStorage.getItem(this.sessionKey)) {
                            alert('Tes sedang berlangsung di jendela lain. Jendela ini akan ditutup.');
                            window.close();
                            return;
                        }
                    }

                    // ==== Proteksi beforeunload: pasang SEKALI (capture: true) ====
                    if (!window.__examUnloadAttached) {
                        this.beforeUnloadHandler = (e) => {
                            if (!this.preventUnload) return;
                            e.preventDefault();
                            e.returnValue = ''; // sumber dialog; akan kita lepas sebelum submit/end
                        };
                        window.addEventListener('beforeunload', this.beforeUnloadHandler, {
                            capture: true
                        });
                        window.__examUnloadAttached = true;
                    }

                    // ==== Guards lain ====
                    this.bindGuards();

                    // ==== Re-bind setelah Livewire re-render (tanpa pasang beforeunload ulang) ====
                    document.addEventListener('livewire:navigated', () => this.bindGuards());
                    if (window.Livewire) {
                        Livewire.hook?.('message.processed', () => this.bindGuards());
                    }
                },

                /* ---------- guards ---------- */
                bindGuards() {
                    const opts = {
                        capture: true
                    };

                    // Cegah back (tanpa alert blocking)
                    history.pushState(null, '', location.href);
                    window.onpopstate = () => {
                        history.pushState(null, '', location.href);
                    };

                    // Context menu & clipboard
                    document.addEventListener('contextmenu', this._ctxPrevent ||= (e) => {
                        e.preventDefault();
                        this._recordViolation('contextmenu', 'action');
                    }, opts);

                    ['copy', 'cut', 'paste'].forEach(type => {
                        const key = `_${type}Prevent`;
                        document.addEventListener(type, this[key] ||= (e) => {
                            e.preventDefault();
                            this._recordViolation(type, 'action');
                        }, opts);
                    });

                    // (opsional) blokir right-click via mouse
                    document.addEventListener('mousedown', this._mdPrevent ||= (e) => {
                        if (e.button === 2) {
                            e.preventDefault();
                            this._recordViolation('right_click', 'action');
                        }
                    }, opts);

                    // Keyboard shortcuts
                    document.addEventListener('keydown', this._kd ||= (e) => this.blockKeys(e), opts);
                    document.addEventListener('keypress', this._kp ||= (e) => this.blockKeys(e), opts);

                    // Fokus/visibility → hitung pelanggaran
                    document.addEventListener('visibilitychange', this._visCb ||= () => {
                        if (document.hidden) this._recordViolation('focus_lost_visibilitychange', 'focus');
                    }, opts);

                    // Jika mau hitung blur window, aktifkan:
                    // window.addEventListener('blur', this._blurCb ||= () => {
                    //   this._recordViolation('focus_lost_blur', 'focus');
                    // }, opts);

                    // DevTools heuristik (opsional)
                    clearInterval(this._devIntv);
                    this._devIntv = setInterval(() => {
                        const t = 160;
                        const open = (window.outerWidth - window.innerWidth > t) ||
                            (window.outerHeight - window.innerHeight > t);
                        if (open) this._recordViolation('devtools_open', 'devtools');
                    }, 1500);
                },

                blockKeys(e) {
                    const key = (e.key || '').toLowerCase();
                    const ctrl = e.ctrlKey || e.metaKey;
                    const shift = e.shiftKey;
                    const tag = (e.target?.tagName || '').toUpperCase();

                    // refresh/back
                    if (key === 'f5' || (ctrl && key === 'r')) {
                        e.preventDefault();
                    }

                    // backspace di luar input/textarea
                    if (key === 'backspace' && !['INPUT', 'TEXTAREA'].includes(tag)) {
                        e.preventDefault();
                    }

                    // clipboard / save / print / view source / select all
                    if (ctrl && ['c', 'x', 's', 'p', 'u', 'a'].includes(key)) {
                        e.preventDefault();
                    }

                    // devtools (aktifkan F12 jika mau)
                    // if (key === 'f12') { e.preventDefault(); }
                    if (ctrl && shift && ['i', 'c', 'j'].includes(key)) {
                        e.preventDefault();
                    }
                },

                /* ---------- helpers ---------- */
                _recordViolation(name, kind = 'focus') {
                    // Kirim payload PRIMITIF ke Livewire (hindari objek event)
                    if (window.Livewire) {
                        if (typeof Livewire.emit === 'function') {
                            Livewire.emit('exam-client-event', String(name), String(kind), new Date().toISOString());
                        } else if (typeof Livewire.dispatch === 'function') {
                            Livewire.dispatch('exam-client-event', {
                                name: String(name),
                                kind: String(kind),
                                at: new Date().toISOString()
                            });
                        }
                    }

                    if (kind === 'devtools') this.devtoolsViolations++;
                    if (kind === 'focus') this.focusViolations++;

                    const total = Math.max(this.focusViolations, this.devtoolsViolations);
                    if (total >= this.maxViolations) this.endByViolation('too_many_violations');
                },

                endByViolation(reason = 'too_many_violations') {
                    // Lepas guard dulu supaya tidak ada dialog
                    this.disableUnloadGuard();

                    if (window.Livewire) {
                        if (typeof Livewire.emit === 'function') {
                            Livewire.emit('force-submit-exam', String(reason));
                        } else if (typeof Livewire.dispatch === 'function') {
                            Livewire.dispatch('force-submit-exam', {
                                reason: String(reason)
                            });
                        }
                    }
                },

                disableUnloadGuard() {
                    this.preventUnload = false;

                    // Lepas listener yang kita pasang (pakai opsi yang sama)
                    if (this.beforeUnloadHandler) {
                        try {
                            window.removeEventListener('beforeunload', this.beforeUnloadHandler, {
                                capture: true
                            });
                        } catch (_) {}
                        try {
                            window.removeEventListener('beforeunload', this.beforeUnloadHandler);
                        } catch (_) {}
                        this.beforeUnloadHandler = null;
                    }

                    // Antisipasi handler lain yang mungkin dipasang via assignment
                    window.onbeforeunload = null;

                    // Izinkan attach ulang jika diperlukan kemudian
                    window.__examUnloadAttached = false;
                }
            };
        }
    </script>



    <script>
        // Util: format 00:00:00
        const fmt2 = n => n.toString().padStart(2, '0');

        const setChip = (chipEl, status) => {
            // reset classes
            chipEl.classList.remove(
                'bg-emerald-100', 'text-emerald-700', 'dark:bg-emerald-500/10', 'dark:text-emerald-400',
                'bg-amber-100', 'text-amber-700', 'dark:bg-amber-500/10', 'dark:text-amber-400',
                'bg-rose-100', 'text-rose-700', 'dark:bg-rose-500/10', 'dark:text-rose-400',
                'bg-gray-200', 'text-gray-600', 'dark:bg-neutral-700', 'dark:text-neutral-300'
            );
            if (status === 'safe') {
                chipEl.classList.add('bg-emerald-100', 'text-emerald-700', 'dark:bg-emerald-500/10',
                    'dark:text-emerald-400');
                chipEl.textContent = 'Aman';
            } else if (status === 'warn') {
                chipEl.classList.add('bg-amber-100', 'text-amber-700', 'dark:bg-amber-500/10', 'dark:text-amber-400');
                chipEl.textContent = 'Menipis';
            } else if (status === 'danger') {
                chipEl.classList.add('bg-rose-100', 'text-rose-700', 'dark:bg-rose-500/10', 'dark:text-rose-400');
                chipEl.textContent = 'Kritis';
            } else {
                chipEl.classList.add('bg-gray-200', 'text-gray-600', 'dark:bg-neutral-700', 'dark:text-neutral-300');
                chipEl.textContent = 'Selesai';
            }
        };

        // Inisialisasi semua card countdown
        document.querySelectorAll('[data-deadline]').forEach(container => {
            const deadlineStr = container.getAttribute('data-deadline'); // ISO 8601
            const finishedText = container.getAttribute('data-finished-text') || 'Waktu habis';
            const deadline = new Date(deadlineStr).getTime();

            const outEl = container.querySelector('.js-countdown');
            const chipEl = container.querySelector('.js-countdown-chip');
            const progressEl = container.parentElement.nextElementSibling?.querySelector(
                '.js-countdown-progress'); // progress bar (opsional)

            // Jika ingin progress berdasarkan total durasi, Anda bisa kirim data-start (ISO) juga.
            const startAttr = container.getAttribute('data-start'); // optional
            const startMs = startAttr ? new Date(startAttr).getTime() : null;

            const tick = () => {
                const now = Date.now();
                const diff = Math.max(0, deadline - now);

                if (diff === 0) {
                    Livewire.dispatch('test-timeout')
                    outEl.textContent = finishedText;
                    setChip(chipEl, 'done');
                    if (progressEl) progressEl.style.width = '100%';
                    clearInterval(timer);
                    return;
                }

                const days = Math.floor(diff / 86400000);
                const hours = Math.floor((diff % 86400000) / 3600000);
                const mins = Math.floor((diff % 3600000) / 60000);
                const secs = Math.floor((diff % 60000) / 1000);

                // Tampilkan D jika ada, lalu HH:MM:SS
                outEl.textContent = (days ? days + 'h ' : '') + `${fmt2(hours)}:${fmt2(mins)}:${fmt2(secs)}`;

                // Status warna chip: <= 10m => danger, <= 30m => warn, else safe
                const tenMin = 10 * 60 * 1000;
                const thirtyMin = 30 * 60 * 1000;
                if (diff <= tenMin) setChip(chipEl, 'danger');
                else if (diff <= thirtyMin) setChip(chipEl, 'warn');
                else setChip(chipEl, 'safe');

                // Progress (opsional): butuh start time untuk akurat; tanpa start kita estimasi 0→100% mendekati deadline
                if (progressEl) {
                    let pct = 0;
                    if (startMs && deadline > startMs) {
                        const total = deadline - startMs;
                        pct = Math.min(100, Math.max(0, ((now - startMs) / total) * 100));
                    } else {
                        // fallback: mendekati 100% saat diff→0 (kurang akurat, tapi cukup informatif)
                        pct = Math.min(100, Math.max(0, 100 - (diff / (6 * 60 * 60 * 1000)) *
                            100)); // skala 6 jam
                    }
                    progressEl.style.width = pct + '%';
                    // warna progress mengikuti chip (cukup via utility)
                    if (diff <= tenMin) {
                        progressEl.className = 'js-countdown-progress h-2 rounded-full bg-rose-500';
                    } else if (diff <= thirtyMin) {
                        progressEl.className = 'js-countdown-progress h-2 rounded-full bg-amber-500';
                    } else {
                        progressEl.className = 'js-countdown-progress h-2 rounded-full bg-emerald-500';
                    }
                }
            };

            // Jalankan
            tick();
            const timer = setInterval(tick, 1000);
        });
    </script>
</div>
