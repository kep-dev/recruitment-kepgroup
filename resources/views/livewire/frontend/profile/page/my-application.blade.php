<div class="col-span-full md:col-span-full lg:col-span-9 space-y-4">
    <div
        class="col-span-full md:col-span-full lg:col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
        <strong>
            <h2 class="text-3xl text-gray-800 dark:text-slate-100">Lamaran Saya</h2>
        </strong>
    </div>

    @forelse ($this->applications as $application)
        <a href="{{ !now()->gte(\Carbon\Carbon::parse($application->jobVacancy->end_date)) ? route('frontend.job.show', $application->jobVacancy->slug) : 'javascript:;' }}"
            class="block rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800">
            <div class="flex items-start gap-4 p-4 md:p-5">
                <!-- Logo -->
                <div class="shrink-0">
                    <img src="{{ Storage::disk('public')->url($application->jobVacancy->imag) }}" alt="Company Logo"
                        class="size-12 md:size-14 rounded-md object-cover">
                </div>

                <!-- Middle -->
                <div class="min-w-0 flex-1">
                    <!-- Title -->
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 leading-snug dark:text-neutral-100">
                        {{ $application->jobVacancy->title }}
                    </h3>
                    <!-- Company & meta line -->
                    <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                        <!-- Chips -->
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ $application->jobVacancy->employeeType->name }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ $application->jobVacancy->jobLevel->name }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ $application->jobVacancy->workType->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Quota -->
                    <p class="my-2 text-xs text-gray-400 dark:text-neutral-500">Jumlah pelamar saat ini :
                        {{ $application->jobVacancy->applications->count() }}
                    </p>
                    {{-- <a href="{{ route('frontend.job.show', $application->jobVacancy->slug) }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20">
                        Lihat Lowongan
                    </a> --}}
                    @if ($application->jobVacancy->status != 1 || !now()->gte(\Carbon\Carbon::parse($application->jobVacancy->end_date)))
                        <button type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="CancelModal"
                            data-hs-overlay="#CancelModal"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-hidden focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20"
                            @click.prevent="$dispatch('cancel-apply', {id: '{{ $application->id }}'})">
                            Batalkan Lamaran
                        </button>
                    @endif
                </div>

                <!-- Right: location + save -->
                <div class="ms-auto flex items-center gap-4">
                    <div class="hidden sm:flex items-center text-sm text-gray-600 dark:text-neutral-300">
                        <!-- map-pin icon -->
                        <div>
                            <span
                                class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium text-teal-800 rounded-full dark:text-teal-500">
                                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                    </path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                @if (!now()->gte(\Carbon\Carbon::parse($application->jobVacancy->end_date)))
                                    Berakhir dalam
                                    {{ (int) \Carbon\Carbon::parse(now())->diffInDays(\Carbon\Carbon::parse($application->jobVacancy->end_date)) }}
                                    hari
                                @else
                                    Telah berakhir
                                @endif

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div
            class="col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
            <div class="mx-auto mb-6 md:mb-8 size-36 md:size-44">
                <!-- Ganti dengan img/svg kamu sendiri jika perlu -->
                <svg viewBox="0 0 240 180" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="g1" x1="0" x2="1">
                            <stop offset="0" stop-color="#A78BFA" />
                            <stop offset="1" stop-color="#7C3AED" />
                        </linearGradient>
                    </defs>
                    <!-- blob -->
                    <circle cx="85" cy="70" r="55" fill="#EDE9FE" />
                    <!-- folder -->
                    <rect x="60" y="70" width="90" height="55" rx="6" fill="url(#g1)" />
                    <rect x="60" y="60" width="40" height="18" rx="4" fill="#8B5CF6" />
                    <rect x="74" y="74" width="16" height="6" rx="3" fill="#EDE9FE" opacity=".9" />
                    <!-- person w/ binocular -->
                    <circle cx="154" cy="70" r="16" fill="#93C5FD" />
                    <rect x="138" y="68" width="36" height="10" rx="5" fill="#FACC15" />
                    <rect x="160" y="68" width="14" height="10" rx="5" fill="#EAB308" />
                    <path d="M148 84c8 6 18 8 28 6v18h-28V84Z" fill="#93C5FD" />
                </svg>
            </div>
            <!-- Title -->
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-neutral-100 text-center">
                Belum ada lamaran
            </h2>

            <!-- Description -->
            <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-neutral-400 text-center">
                Anda belum melamar pekerjaan apa pun. Mari mulai perjalanan karier Anda dengan menemukan pekerjaan yang
                sesuai dengan minat Anda!
            </p>

            <!-- CTA -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('frontend.job') }}" wire:navigate
                    class="inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium
                bg-violet-700 text-white hover:bg-violet-800 focus:outline-hidden focus:ring-2 focus:ring-violet-500
                hs-button">
                    Cari Lowongan
                </a>
            </div>
        </div>
    @endforelse
    {{ $this->applications->links() }}

    <div id="CancelModal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto"
        role="dialog" tabindex="-1" aria-labelledby="CancelModal-label" wire:ignore wire:ignore.self>
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
            <div
                class="relative flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
                <div class="absolute top-2 end-2">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#CancelModal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 sm:p-10 overflow-y-auto">
                    <div class="flex gap-x-4 md:gap-x-7">
                        <!-- Icon -->
                        <span
                            class="shrink-0 inline-flex justify-center items-center size-11 sm:w-15.5 sm:h-15.5 rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                        </span>
                        <!-- End Icon -->

                        <div class="grow">
                            <h3 id="CancelModal-label"
                                class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                Batalkan Lamaran
                            </h3>
                            <p class="text-gray-500 dark:text-neutral-500">
                                Apakah kamu yakin ingin membatalkan lamaran ini?
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t border-gray-200 dark:bg-neutral-950 dark:border-neutral-800">
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        data-hs-overlay="#CancelModal">
                        Batal
                    </button>
                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none"
                        href="javascript:;"
                        @click="$wire.cancelApplication(); $nextTick(() => {
                            HSOverlay.close('#CancelModal')
                        })">
                        Batalkan Lamaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <x-molecules.alerts.alert />

    @script
        <script>
            document.addEventListener('cancel-apply', (e) => {
                // alert('aaaa')
                HSOverlay.open('#CancelModal')
            })
        </script>
    @endscript

</div>
