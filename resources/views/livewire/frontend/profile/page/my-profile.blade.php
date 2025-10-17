<div class=" col-span-full md:col-span-full lg:col-span-9 space-y-4">
    <div
        class="col-span-full md:col-span-full lg:col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
        <strong>
            <h2 class="text-3xl text-gray-800 dark:text-slate-100">My Profile</h2>
        </strong>
    </div>

    @php
        // Ambil sisa cooldown langsung dari RateLimiter agar tahan refresh
        $userId = optional(auth()->user())->getAuthIdentifier();
        $key = $userId ? 'resend-verif:' . $userId : null;
        $cooldown = $key ? \Illuminate\Support\Facades\RateLimiter::availableIn($key) : 0;
    @endphp

    <div
        class="col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5">
        <h4 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-6">Status Email</h4>

        <div class="flex justify-between items-center ">
            @if (auth()->user()->hasVerifiedEmail())
                <div class="mt-1 inline-flex items-center gap-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check text-green-600">
                        <path
                            d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                    <p class="text-green-600">
                        Email sudah terverifikasi
                    </p>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    <span class="text-red-600 font-semibold">Email belum terverifikasi</span>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button id="resend-btn" type="submit" data-initial-cooldown="{{ (int) $cooldown }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                   disabled:opacity-50 disabled:pointer-events-none">
                            <span data-label>Verifikasi Email</span>
                        </button>
                    </form>

                    <p id="cooldown-info" class="hidden text-xs text-gray-500 dark:text-neutral-400">
                        Tunggu <span id="cooldown-secs">{{ (int) $cooldown }}</span> detik untuk kirim lagi.
                    </p>
                </div>
            @endif
        </div>
    </div>


    <livewire:frontend.profile.partials.personal-information :user="$user" />
    {{-- <livewire:frontend.profile.partials.professional-headline :user="$user" /> --}}
    <livewire:frontend.profile.partials.latest-education :user="$user" />
    <livewire:frontend.profile.partials.work-experience :user="$user" />
    <livewire:frontend.profile.partials.organization-experience :user="$user" />
    <livewire:frontend.profile.partials.training-certification :user="$user" />
    <livewire:frontend.profile.partials.achievement :user="$user" />
    <livewire:frontend.profile.partials.language :user="$user" />
    <livewire:frontend.profile.partials.applicant-skill :user="$user" />
    <livewire:frontend.profile.partials.applicant-social-media :user="$user" />
    {{-- <livewire:frontend.profile.partials.applicant-salary :user="$user" /> --}}
    <livewire:frontend.profile.partials.applicant-document :user="$user" />

    {{-- Years of Full-time Work Experience --}}
    {{-- <div class="col-span-full md:col-span-full lg:col-span-9">
        <div
            class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl">
            <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                    Years of Full-time Work Experience
                </h3>
            </div>
            <div class="p-4 md:p-5">
                <p class="text-gray-500">
                    With supporting text below as a natural lead-in to additional content.
                </p>
            </div>
        </div>
    </div> --}}
    {{-- Years of Full-time Work Experience --}}

    <x-molecules.alerts.alert />

    <script>
        (function() {
            const btn = document.getElementById('resend-btn');
            if (!btn) return; // sudah verified, tidak ada tombol

            const info = document.getElementById('cooldown-info');
            const secs = document.getElementById('cooldown-secs');
            const label = btn.querySelector('[data-label]');

            let remaining = parseInt(btn.dataset.initialCooldown || '0', 10);

            function setDisabled(on) {
                btn.disabled = on;
                if (on) {
                    info.classList.remove('hidden');
                    label.textContent = 'Menunggu...';
                } else {
                    info.classList.add('hidden');
                    label.textContent = 'Verifikasi Email';
                }
            }

            function tick() {
                if (remaining <= 0) {
                    setDisabled(false);
                    return;
                }
                setDisabled(true);
                if (secs) secs.textContent = remaining;
                remaining -= 1;
                setTimeout(tick, 1000);
            }

            if (remaining > 0) tick();
        })();
    </script>

</div>
