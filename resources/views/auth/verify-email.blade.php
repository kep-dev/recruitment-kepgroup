<x-layouts.guest title="Verifikasi Email">
    <div
        class="max-w-[560px] w-full mx-auto mt-10 bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700">
        <div class="p-6 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Verify your email</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                    Kami sudah mengirimkan tautan verifikasi ke email kamu.
                    Belum menerima?
                    <span class="font-medium text-gray-800 dark:text-neutral-200">Kirim ulang di bawah.</span>
                </p>
            </div>

            @if (session('toast'))
                <div
                    class="mt-4 text-sm rounded-lg px-3 py-2
                  {{ session('toast.type') === 'warning' ? 'bg-amber-100 text-amber-800 dark:bg-amber-400/10 dark:text-amber-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-400/10 dark:text-blue-300' }}">
                    {{ session('toast.text') }}
                </div>
            @endif

            <div class="mt-6">
                <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
                    @csrf
                    <div class="grid gap-y-4">

                        {{-- Tombol Kirim Ulang --}}
                        <button type="submit" id="resend-btn"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent
                   bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span id="btn-text">Kirim ulang email verifikasi</span>
                        </button>

                        {{-- Info cooldown --}}
                        <p id="cooldown-info" class="hidden text-xs text-gray-500 dark:text-neutral-400 text-center">
                            Tunggu <span id="cooldown-secs">60</span> detik untuk kirim lagi.
                        </p>

                        {{-- Link kembali / logout --}}
                        <div class="text-center">
                            <a href="{{ route('frontend.job') }}"
                                class="text-sm text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 underline">
                                Kembali ke daftar pekerjaan
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const initial = {{ (int) ($cooldown ?? 0) }}; // <-- dari route GET, bukan session()
            const btn = document.getElementById('resend-btn');
            const info = document.getElementById('cooldown-info');
            const secsEl = document.getElementById('cooldown-secs');
            const btnText = document.getElementById('btn-text');

            let remaining = initial;

            function setDisabled(on) {
                btn.disabled = on;
                if (on) {
                    info.classList.remove('hidden');
                    btnText.textContent = 'Menunggu...';
                } else {
                    info.classList.add('hidden');
                    btnText.textContent = 'Kirim ulang email verifikasi';
                }
            }

            function tick() {
                if (remaining <= 0) {
                    setDisabled(false);
                    return;
                }
                setDisabled(true);
                secsEl.textContent = remaining;
                remaining -= 1;
                setTimeout(tick, 1000);
            }

            if (remaining > 0) tick();
        })();
    </script>

</x-layouts.guest>
