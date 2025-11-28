<div class="min-h-screen bg-slate-50 dark:bg-neutral-900 py-10">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Tes --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">
                    Psikotes – {{ $attempt->form->name ?? 'Paket Psikotes' }}
                </p>
                <h1 class="mt-1 text-xl sm:text-2xl font-semibold text-slate-900 dark:text-neutral-50">
                    Soal {{ $this->currentNumber }} dari {{ $totalQuestions }}
                </h1>
                <p class="text-sm text-slate-500 dark:text-neutral-400">
                    Pilih pernyataan yang paling menggambarkan diri Anda.
                </p>
            </div>

            {{-- contoh badge status --}}
            <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 dark:border-neutral-700 bg-white/80 dark:bg-neutral-900/80 px-4 py-2 shadow-sm"
                data-deadline="{{ \Illuminate\Support\Carbon::parse($attempt->deadline_at)->toIso8601String() }}"
                data-start="{{ \Illuminate\Support\Carbon::parse($attempt->started_at ?? now())->toIso8601String() }}"
                data-finished-text="Waktu habis" wire:ignore>
                {{-- Chip status waktu: Aman / Menipis / Kritis / Selesai --}}
                <span
                    class="js-countdown-chip inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-700 dark:bg-neutral-700 dark:text-neutral-200">
                    <!-- akan diisi JS, default sementara -->
                    …
                </span>

                <div>
                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-500 dark:text-neutral-400">
                        Sisa Waktu
                    </p>
                    <p class="js-countdown text-sm font-semibold text-slate-900 dark:text-neutral-50">
                        <!-- akan diisi JS -->
                    </p>
                </div>
            </div>

            <div
                class="inline-flex items-center gap-2 rounded-full border border-slate-200 dark:border-neutral-700 bg-white/80 dark:bg-neutral-900/80 px-4 py-2 shadow-sm">
                <span
                    class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-900 text-white text-xs font-semibold dark:bg-slate-100 dark:text-neutral-900">
                    {{ strtoupper(substr($attempt->status->getLabel(), 0, 1)) }}
                </span>
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-500 dark:text-neutral-400">
                        Status
                    </p>
                    <p class="text-sm font-semibold text-slate-900 dark:text-neutral-50">
                        {{ $attempt->status->getLabel() }}
                    </p>
                </div>
            </div>
        </div>

        <div
            class="mt-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:bg-neutral-900 dark:border-neutral-800 mb-6">
            <div class="mb-3 text-sm font-medium text-gray-700 dark:text-neutral-200">
                Navigasi Soal
            </div>

            <div class="grid grid-cols-10 sm:grid-cols-12 md:grid-cols-15 gap-2">
                @foreach ($this->questions as $i => $q)
                    @php
                        $qid = $q->id;
                        $answered = isset($answerMap[$qid]) && $answerMap[$qid];
                        $isActive = $i === $currentIndex;
                    @endphp

                    <button type="button" wire:click="selectIndex({{ $i }})"
                        class="w-full aspect-square rounded-lg text-sm font-semibold
                @if ($isActive) bg-gray-900 text-white dark:bg-white dark:text-neutral-900
                @elseif($answered)
                    bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-400
                @else
                    bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700 @endif">
                        {{ $i + 1 }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Progress --}}
        <div class="mb-6">
            @php
                $progress = $totalQuestions > 0 ? round(($this->currentNumber / $totalQuestions) * 100) : 0;
            @endphp
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-medium text-slate-500 dark:text-neutral-400">
                    Progres Pengerjaan
                </span>
                <span class="text-xs font-semibold text-slate-700 dark:text-neutral-200">
                    {{ $progress }}%
                </span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-neutral-800">
                <div class="h-full rounded-full bg-slate-900 dark:bg-slate-100 transition-all duration-300"
                    style="width: {{ $progress }}%"></div>
            </div>
        </div>

        @if (!$this->currentQuestion)
            <div
                class="rounded-2xl border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-6 text-center text-sm text-slate-600 dark:text-neutral-300">
                Tidak ada soal yang tersedia untuk psikotest ini.
            </div>
            @return
        @endif

        {{-- Error global --}}
        @if ($errors->has('selectedOptionId'))
            <div
                class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800 dark:border-amber-900/60 dark:bg-amber-900/30 dark:text-amber-100">
                {{ $errors->first('selectedOptionId') }}
            </div>
        @endif

        {{-- Card Soal --}}
        <div
            class="mb-6 rounded-2xl border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-sm">
            <div class="border-b border-slate-100 dark:border-neutral-800 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-neutral-50">
                    Pilih salah satu pernyataan berikut:
                </h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-neutral-400">
                    Tidak ada jawaban benar atau salah. Jawablah dengan jujur sesuai diri Anda.
                </p>
            </div>

            <div class="p-5 grid gap-4 sm:grid-cols-2">
                @foreach ($this->currentQuestion->options as $option)
                    <button type="button" wire:click="selectOption('{{ $option->id }}')"
                        class="group relative flex flex-col gap-2 rounded-xl border bg-white dark:bg-neutral-900 p-4 text-left shadow-sm transition-all
              border-slate-200 hover:border-slate-400 hover:shadow
              dark:border-neutral-700 dark:hover:border-neutral-500
              @if ($selectedOptionId === $option->id) ring-2 ring-slate-900 border-slate-900
                  dark:ring-slate-100 dark:border-slate-100 @endif">
                        <div class="flex items-start gap-3">
                            <span
                                class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold
                                border-slate-300 bg-slate-50 text-slate-700
                                dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                {{ $option->label }}
                            </span>
                            <p class="text-sm leading-relaxed text-slate-800 dark:text-neutral-100">
                                {{ $option->statement }}
                            </p>
                        </div>

                        <div
                            class="mt-2 flex items-center justify-between text-[11px] text-slate-400 dark:text-neutral-500">
                            <div class="inline-flex items-center gap-1">
                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                    @if ($selectedOptionId === $option->id) bg-emerald-500
                                    @else
                                        bg-slate-300 dark:bg-neutral-600 @endif"></span>
                                <span>
                                    @if ($selectedOptionId === $option->id)
                                        Dipilih
                                    @else
                                        Klik untuk memilih
                                    @endif
                                </span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Navigasi Soal --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex gap-2">
                @if ($this->currentNumber > 1)
                    <button type="button" wire:click="goToPrev"
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-700 shadow-sm
                               hover:border-slate-300 hover:bg-slate-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Sebelumnya
                    </button>
                @endif
            </div>


            <div class="flex flex-wrap items-center gap-2">
                <button type="button" wire:click="saveAndNext"
                    class="inline-flex items-center gap-1.5 rounded-full bg-slate-900 px-5 py-2 text-xs font-medium text-white shadow-sm
           hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-50
           dark:bg-slate-100 dark:text-neutral-900 dark:hover:bg-slate-200 dark:focus:ring-slate-300 dark:focus:ring-offset-neutral-900">
                    @if ($this->currentNumber < $totalQuestions)
                        Selanjutnya
                    @else
                        Simpan & Selesai
                    @endif
                </button>
            </div>
        </div>
    </div>

    <x-molecules.alerts.alert />

    <script>
        // Util: format 00
        const fmt2 = n => n.toString().padStart(2, '0');

        const setChip = (chipEl, status) => {
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

        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi semua countdown
            document.querySelectorAll('[data-deadline]').forEach(container => {
                const deadlineStr = container.getAttribute('data-deadline'); // ISO 8601
                const finishedText = container.getAttribute('data-finished-text') || 'Waktu habis';
                const startAttr = container.getAttribute('data-start'); // optional

                const deadline = new Date(deadlineStr).getTime();
                const startMs = startAttr ? new Date(startAttr).getTime() : null;

                const outEl = container.querySelector('.js-countdown');
                const chipEl = container.querySelector('.js-countdown-chip');
                const progressEl = container.parentElement.nextElementSibling?.querySelector(
                    '.js-countdown-progress');

                if (!outEl || !chipEl) {
                    return;
                }

                const tick = () => {
                    const now = Date.now();
                    const diff = Math.max(0, deadline - now);

                    if (diff === 0) {
                        // waktu habis
                        outEl.textContent = finishedText;
                        setChip(chipEl, 'done');
                        if (progressEl) {
                            progressEl.style.width = '100%';
                            progressEl.className = 'js-countdown-progress h-2 rounded-full bg-rose-500';
                        }

                        // beritahu Livewire kalau ingin auto-submit / timeout
                        if (window.Livewire) {
                            Livewire.dispatch('test-timeout');
                        }

                        clearInterval(timer);
                        return;
                    }

                    const hours = Math.floor(diff / 3600000);
                    const mins = Math.floor((diff % 3600000) / 60000);
                    const secs = Math.floor((diff % 60000) / 1000);

                    outEl.textContent = `${fmt2(hours)}:${fmt2(mins)}:${fmt2(secs)}`;

                    const tenMin = 10 * 60 * 1000;
                    const thirtyMin = 30 * 60 * 1000;

                    if (diff <= tenMin) {
                        setChip(chipEl, 'danger');
                    } else if (diff <= thirtyMin) {
                        setChip(chipEl, 'warn');
                    } else {
                        setChip(chipEl, 'safe');
                    }

                    // Progress bar
                    if (progressEl) {
                        let pct = 0;
                        if (startMs && deadline > startMs) {
                            const total = deadline - startMs;
                            pct = Math.min(100, Math.max(0, ((now - startMs) / total) * 100));
                        } else {
                            // fallback: skala kasar sampai 6 jam
                            pct = Math.min(100, Math.max(0, 100 - (diff / (6 * 60 * 60 * 1000)) * 100));
                        }

                        progressEl.style.width = pct + '%';

                        if (diff <= tenMin) {
                            progressEl.className = 'js-countdown-progress h-2 rounded-full bg-rose-500';
                        } else if (diff <= thirtyMin) {
                            progressEl.className =
                                'js-countdown-progress h-2 rounded-full bg-amber-500';
                        } else {
                            progressEl.className =
                                'js-countdown-progress h-2 rounded-full bg-emerald-500';
                        }
                    }
                };

                // pertama kali & interval
                tick();
                const timer = setInterval(tick, 1000);
            });
        });
    </script>


</div>
