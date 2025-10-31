@props([
    // attemptId wajib di exam.show, boleh null di exam.index (pakai group/test id)
    'attemptId' => null,
    // optional: kunci session untuk index (mis. jobVacancyTestId / paket)
    'sessionKey' => null,
])

<div x-data="examGuard({
    attemptId: @js($attemptId),
    sessionKey: @js($sessionKey),
})" x-init="init()" x-on:keydown.window="blockKeys($event)" style="display:none"
    {{-- elemen “jangkar”, tidak mengganggu UI --}}></div>

@once
    @push('scripts')
        <script>
            window.examGuard = function({
                attemptId = null,
                sessionKey = null
            } = {}) {
                // fallback session key
                const key = sessionKey || `exam_session_${attemptId ?? 'index'}`;

                return {
                    sessionKey: key,
                    bc: null,
                    isExamWindow: window.opener != null,
                    preventUnload: true,
                    focusViolations: 0,
                    maxFocusViolations: 3,

                    init() {
                        // BroadcastChannel untuk koordinasi multi-window/tab
                        this.bc = new BroadcastChannel(this.sessionKey);

                        // Tutup halaman liar kalau sesi sudah aktif & ini bukan window resmi
                        this.bc.onmessage = (e) => {
                            if (e.data === 'EXAM_ALREADY_ACTIVE' && !this.isExamWindow) {
                                alert('Tes sudah aktif di jendela lain. Jendela ini akan ditutup.');
                                window.close();
                            }
                            if (e.data?.type === 'request-fullscreen') this.requestFullscreen();
                        };

                        // Umumkan eksistensi ke jendela lain
                        this.bc.postMessage('EXAM_ALREADY_ACTIVE');

                        // Tandai aktif hanya pada jendela ujian resmi (dibuka via window.open)
                        if (this.isExamWindow) {
                            localStorage.setItem(this.sessionKey, String(Date.now()));
                            window.addEventListener('beforeunload', () => {
                                localStorage.removeItem(this.sessionKey);
                                this.bc?.close();
                            });
                        } else {
                            // Jika user buka manual saat sudah ada jendela ujian → tutup
                            if (localStorage.getItem(this.sessionKey)) {
                                alert('Tes sedang berlangsung di jendela lain. Jendela ini akan ditutup.');
                                window.close();
                                return;
                            }
                        }

                        // Guard umum
                        this.bindGuards();

                        // Re-bind setelah Livewire merender ulang (v3)
                        document.addEventListener('livewire:navigated', () => this.bindGuards());
                        if (window.Livewire) {
                            Livewire.hook('message.processed', () => this.bindGuards());
                        }
                    },

                    bindGuards() {
                        // Cegah refresh/back
                        window.onbeforeunload = (e) => {
                            if (this.preventUnload) {
                                e.preventDefault();
                                e.returnValue = '';
                            }
                        };
                        history.pushState(null, '', location.href);
                        window.onpopstate = () => {
                            history.pushState(null, '', location.href);
                            alert('Navigasi mundur dinonaktifkan selama tes.');
                        };

                        // Blok context menu & clipboard
                        document.addEventListener('contextmenu', this._ctxPrevent = (e) => e.preventDefault(), {
                            once: false
                        });
                        document.addEventListener('copy', this._cpyPrevent = (e) => e.preventDefault(), {
                            once: false
                        });
                        document.addEventListener('cut', this._cutPrevent = (e) => e.preventDefault(), {
                            once: false
                        });
                        document.addEventListener('paste', this._pstPrevent = (e) => e.preventDefault(), {
                            once: false
                        });

                        // Fokus/visibility
                        document.addEventListener('visibilitychange', this._visCb = () => {
                            if (document.hidden) this._focusLost('visibilitychange');
                        }, {
                            once: false
                        });

                        window.addEventListener('blur', this._blurCb = () => this._focusLost('blur'), {
                            once: false
                        });

                        // DevTools heuristik
                        clearInterval(this._devIntv);
                        this._devIntv = setInterval(() => {
                            const t = 160;
                            const open = (window.outerWidth - window.innerWidth > t) || (window.outerHeight - window
                                .innerHeight > t);
                            if (open) {
                                this._report('devtools_open');
                                alert('DevTools terdeteksi. Tes akan diakhiri.');
                                this._forceEnd('devtools');
                            }
                        }, 1500);
                    },

                    blockKeys(e) {
                        const key = e.key.toLowerCase();
                        const ctrl = e.ctrlKey || e.metaKey;
                        const shift = e.shiftKey;

                        // refresh/back
                        if (key === 'f5' || (ctrl && key === 'r')) e.preventDefault();
                        if (key === 'backspace' && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) e.preventDefault();

                        // clipboard / save / print / view source
                        if (ctrl && ['c', 'x', 's', 'p', 'u', 'a'].includes(key)) e.preventDefault();

                        // devtools
                        if (key === 'f12') e.preventDefault();
                        if (ctrl && shift && ['i', 'c', 'j'].includes(key)) e.preventDefault();
                    },

                    requestFullscreen() {
                        const el = document.documentElement;
                        (el.requestFullscreen?.bind(el) ?? el.webkitRequestFullscreen?.bind(el))
                        ?.().catch(() => {});
                    },

                    _focusLost(reason) {
                        this.focusViolations++;
                        this._report('focus_lost_' + reason);
                        if (this.focusViolations >= this.maxFocusViolations) {
                            alert('Anda terlalu sering berpindah jendela/tab. Tes diakhiri.');
                            this._forceEnd('focus');
                        } else {
                            alert(
                                `Jangan berpindah tab/jendela. Peringatan ${this.focusViolations}/${this.maxFocusViolations}.`);
                        }
                    },

                    _report(event) {
                        if (window.Livewire) {
                            Livewire.dispatch('exam-client-event', {
                                event,
                                at: new Date().toISOString()
                            });
                        }
                    },

                    _forceEnd(reason) {
                        this.preventUnload = false;
                        if (window.Livewire) {
                            Livewire.dispatch('force-submit-exam', {
                                reason
                            });
                        }

                    },
                };
            };
        </script>

        <style>
            /* Anti-seleksi dasar. Input tetap bisa pilih teks. */
            body,
            [data-no-select] {
                user-select: none;
                -webkit-user-select: none;
            }

            input,
            textarea,
            [contenteditable="true"] {
                user-select: text;
                -webkit-user-select: text;
            }
        </style>
    @endpush
@endonce
