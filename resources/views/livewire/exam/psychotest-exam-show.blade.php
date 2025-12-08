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
        <div -
            class="mb-6 rounded-2xl border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-sm">
            + <div id="js-question-card" +
                class="relative mb-6 rounded-2xl border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-sm">
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

    {{-- <script>
        (function() {
            const watermarkId = 'exam-watermark';
            const userInfo = "{{ auth()->user()->email ?? (auth()->user()->id ?? 'Peserta') }}";
            const attemptId = "{{ $attempt->id }}";

            const createWatermark = () => {
                if (document.getElementById(watermarkId)) return;
                const el = document.createElement('div');
                el.id = watermarkId;
                el.style.position = 'fixed';
                el.style.top = '0';
                el.style.left = '0';
                el.style.right = '0';
                el.style.bottom = '0';
                el.style.pointerEvents = 'none';
                el.style.zIndex = '999999';
                el.style.display = 'flex';
                el.style.alignItems = 'center';
                el.style.justifyContent = 'center';
                el.style.fontSize = '36px';
                el.style.fontWeight = '600';
                el.style.color = 'rgba(0,0,0,0.06)';
                el.style.transform = 'translateZ(0) rotate(-20deg)';
                el.style.userSelect = 'none';
                el.style.whiteSpace = 'nowrap';
                el.style.overflow = 'hidden';
                el.style.padding = '0 20px';
                // subtle repeated background to make cropping screenshots harder
                el.style.backgroundImage =
                    'repeating-linear-gradient(-30deg, rgba(0,0,0,0.03) 0, rgba(0,0,0,0.03) 1px, transparent 1px, transparent 160px)';
                el.textContent = `${userInfo} • ID:${attemptId} • ${new Date().toLocaleString()}`;
                document.body.appendChild(el);

                // update timestamp to make screenshots traceable
                setInterval(() => {
                    if (document.getElementById(watermarkId)) {
                        el.textContent = `${userInfo} • ID:${attemptId} • ${new Date().toLocaleString()}`;
                    }
                }, 10000);
            };

            createWatermark();

            const reportAttempt = (reason) => {
                // Broadcast so app can show toast / mark attempt
                window.dispatchEvent(new CustomEvent('screenshotAttempt', {
                    detail: {
                        reason
                    }
                }));
                if (window.Livewire && typeof Livewire.dispatch === 'function') {
                    Livewire.dispatch('screenshot-attempt', {
                        reason
                    });
                }
                console.debug('screenshot attempt detected:', reason);
            };

            // Best-effort: block PrintScreen and common shortcuts, then try to clear clipboard
            document.addEventListener('keyup', async (e) => {
                try {
                    if (e.key === 'PrintScreen') {
                        try {
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                await navigator.clipboard.writeText('');
                            }
                        } catch (err) {
                            // clipboard write may be blocked by browser permissions
                        }
                        reportAttempt('printscreen');
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }

                    // Detect Win/Cmd+Shift+S or Ctrl/Cmd+Shift+4 (macOS screenshot) best-effort
                    if (e.shiftKey && (e.key === 'S' || e.key === '4') && (e.metaKey || e.ctrlKey)) {
                        reportAttempt('shortcut-snipping');
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }
                } catch (err) {
                    // noop
                }
            }, true);

            // If tab is hidden or window loses focus, consider it suspicious
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    reportAttempt('visibility-hidden');
                }
            }, true);

            window.addEventListener('blur', () => {
                reportAttempt('window-blur');
            }, true);

            // --- NEW: blur question area while screenshot attempt is flagged ---
            const QUESTION_CARD_ID = 'js-question-card';
            const BLUR_OVERLAY_ID = 'js-blur-overlay';
            const BLUR_DURATION_MS = 8000; // blur duration per attempt

            const applyQuestionBlur = (reason) => {
                const card = document.getElementById(QUESTION_CARD_ID);
                if (!card) return;

                // add blur style
                card.classList.add('exam-blurred');
                // create overlay to block interaction and show message
                if (!document.getElementById(BLUR_OVERLAY_ID)) {
                    const overlay = document.createElement('div');
                    overlay.id = BLUR_OVERLAY_ID;
                    overlay.className = 'absolute inset-0 flex items-center justify-center text-sm font-semibold';
                    overlay.style.background = 'rgba(0,0,0,0.45)';
                    overlay.style.color = '#fff';
                    overlay.style.zIndex = '50';
                    overlay.style.pointerEvents = 'auto';
                    overlay.innerText = 'Tangkapan layar terdeteksi — soal diburamkan untuk sementara';
                    card.appendChild(overlay);
                }

                // auto-remove after duration
                clearTimeout(card._blurTimeout);
                card._blurTimeout = setTimeout(() => {
                    removeQuestionBlur();
                }, BLUR_DURATION_MS);
            };

            const removeQuestionBlur = () => {
                const card = document.getElementById(QUESTION_CARD_ID);
                if (!card) return;
                card.classList.remove('exam-blurred');
                const overlay = document.getElementById(BLUR_OVERLAY_ID);
                if (overlay) overlay.remove();
                clearTimeout(card._blurTimeout);
                delete card._blurTimeout;
            };

            // Listen to the internal event dispatched when a screenshot attempt is detected
            window.addEventListener('screenshotAttempt', (e) => {
                const reason = e?.detail?.reason ?? 'unknown';
                applyQuestionBlur(reason);
            }, true);

            // expose a helper to remove deterrents when exam ends
            window.disableScreenshotDeterrents = function() {
                const wm = document.getElementById(watermarkId);
                if (wm) wm.remove();
                document.removeEventListener('keyup', this, true);
                document.removeEventListener('visibilitychange', this, true);
                window.removeEventListener('blur', this, true);
                // also clear blur if set
                removeQuestionBlur();
            };

            // add minimal CSS for blur (uses inline <style> so Tailwind rebuild not required)
            (function injectBlurStyle() {
                if (document.getElementById('js-exam-blur-style')) return;
                const s = document.createElement('style');
                s.id = 'js-exam-blur-style';
                s.textContent = `
                    #${QUESTION_CARD_ID}.exam-blurred { filter: blur(6px); transition: filter .18s ease; }
                    #${QUESTION_CARD_ID}.exam-blurred * { pointer-events: none !important; }
                `;
                document.head.appendChild(s);
            })();
            // --- END NEW ---

        })();
    </script>

    <script>
        (function() {
            const watermarkId = 'exam-watermark';
            const userInfo = "{{ auth()->user()->email ?? (auth()->user()->id ?? 'Peserta') }}";
            const attemptId = "{{ $attempt->id }}";

            const createWatermark = () => {
                if (document.getElementById(watermarkId)) return;
                const el = document.createElement('div');
                el.id = watermarkId;
                el.style.position = 'fixed';
                el.style.top = '0';
                el.style.left = '0';
                el.style.right = '0';
                el.style.bottom = '0';
                el.style.pointerEvents = 'none';
                el.style.zIndex = '999999';
                el.style.display = 'flex';
                el.style.alignItems = 'center';
                el.style.justifyContent = 'center';
                el.style.fontSize = '36px';
                el.style.fontWeight = '600';
                el.style.color = 'rgba(0,0,0,0.06)';
                el.style.transform = 'translateZ(0) rotate(-20deg)';
                el.style.userSelect = 'none';
                el.style.whiteSpace = 'nowrap';
                el.style.overflow = 'hidden';
                el.style.padding = '0 20px';
                // subtle repeated background to make cropping screenshots harder
                el.style.backgroundImage =
                    'repeating-linear-gradient(-30deg, rgba(0,0,0,0.03) 0, rgba(0,0,0,0.03) 1px, transparent 1px, transparent 160px)';
                el.textContent = `${userInfo} • ID:${attemptId} • ${new Date().toLocaleString()}`;
                document.body.appendChild(el);

                // update timestamp to make screenshots traceable
                setInterval(() => {
                    if (document.getElementById(watermarkId)) {
                        el.textContent = `${userInfo} • ID:${attemptId} • ${new Date().toLocaleString()}`;
                    }
                }, 10000);
            };

            createWatermark();

            const reportAttempt = (reason) => {
                // Broadcast so app can show toast / mark attempt
                window.dispatchEvent(new CustomEvent('screenshotAttempt', {
                    detail: {
                        reason
                    }
                }));
                if (window.Livewire && typeof Livewire.dispatch === 'function') {
                    Livewire.dispatch('screenshot-attempt', {
                        reason
                    });
                }
                console.debug('screenshot attempt detected:', reason);
            };

            // Best-effort: block PrintScreen and common shortcuts, then try to clear clipboard
            document.addEventListener('keyup', async (e) => {
                try {
                    if (e.key === 'PrintScreen') {
                        try {
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                await navigator.clipboard.writeText('');
                            }
                        } catch (err) {
                            // clipboard write may be blocked by browser permissions
                        }
                        reportAttempt('printscreen');
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }

                    // Detect Win/Cmd+Shift+S or Ctrl/Cmd+Shift+4 (macOS screenshot) best-effort
                    if (e.shiftKey && (e.key === 'S' || e.key === '4') && (e.metaKey || e.ctrlKey)) {
                        reportAttempt('shortcut-snipping');
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }
                } catch (err) {
                    // noop
                }
            }, true);

            // If tab is hidden or window loses focus, consider it suspicious
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    reportAttempt('visibility-hidden');
                }
            }, true);

            window.addEventListener('blur', () => {
                reportAttempt('window-blur');
            }, true);

            // expose a helper to remove deterrents when exam ends
            window.disableScreenshotDeterrents = function() {
                const wm = document.getElementById(watermarkId);
                if (wm) wm.remove();
                document.removeEventListener('keyup', this, true);
                document.removeEventListener('visibilitychange', this, true);
                window.removeEventListener('blur', this, true);
            };

        })();
    </script> --}}

    <script>
        (function() {
            // Named handlers so they can be removed later
            const preventContext = (e) => {
                e.preventDefault();
            };
            const preventAux = (e) => {
                if (e.button === 1) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            };
            const beforeUnloadHandler = (e) => {
                const confirmationMessage =
                    'Anda sedang mengerjakan tes. Jika meninggalkan halaman, jawaban mungkin tidak tersimpan.';
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            };
            const preventKey = (e) => {
                const key = e.key;
                // Block common reload/close/devtools shortcuts:
                // F5, F11, F12, Ctrl/Cmd+R, Ctrl+Shift+R, Ctrl/Cmd+W, Ctrl+Shift+I/J
                if (key === 'F5' || key === 'F11' || key === 'F12') {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }
                if ((e.ctrlKey || e.metaKey) && (key === 'r' || key === 'R' || key === 'w' || key === 'W')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }
                if (e.ctrlKey && e.shiftKey && (key === 'R' || key === 'r' || key === 'I' || key === 'i' || key ===
                        'J' || key === 'j')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }
                // Prevent back via Alt+ArrowLeft or Backspace when body is focused
                if ((e.altKey && key === 'ArrowLeft') || (key === 'Backspace' && e.target === document.body)) {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }
            };

            const blockPop = () => {
                history.pushState(null, document.title, location.href);
            };
            const popstateHandler = () => {
                blockPop();
                window.dispatchEvent(new CustomEvent('navigationBlocked', {
                    detail: {
                        reason: 'back'
                    }
                }));
            };

            // Attach handlers
            document.addEventListener('contextmenu', preventContext, true);
            document.addEventListener('auxclick', preventAux, true);
            document.addEventListener('keydown', preventKey, true);
            window.addEventListener('beforeunload', beforeUnloadHandler, true);
            blockPop();
            window.addEventListener('popstate', popstateHandler, true);

            // Expose function to allow navigation when exam finishes
            window.allowExamNavigation = function() {
                document.removeEventListener('contextmenu', preventContext, true);
                document.removeEventListener('auxclick', preventAux, true);
                document.removeEventListener('keydown', preventKey, true);
                window.removeEventListener('beforeunload', beforeUnloadHandler, true);
                window.removeEventListener('popstate', popstateHandler, true);
            };

            // If Livewire emits 'exam-finished', automatically re-enable navigation
            if (window.Livewire && typeof window.Livewire.on === 'function') {
                window.Livewire.on('exam-finished', function() {
                    window.allowExamNavigation();
                });
            }

            // Optional: small visual feedback listener (app can use to show toast)
            window.addEventListener('navigationBlocked', function(e) {
                // noop by default; app can listen to this to show a message
                console.debug('Navigation blocked:', e.detail);
            });
        })();
    </script>

</div>
