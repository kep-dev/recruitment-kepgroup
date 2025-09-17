@use('Carbon\Carbon')
@use('App\Enums\status')
<div class=" col-span-full md:col-span-full lg:col-span-9 space-y-4">
    <div
        class="col-span-full md:col-span-full lg:col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
        <strong>
            <h2 class="text-3xl text-gray-800 dark:text-slate-100">Jadwal Tes</h2>
        </strong>
    </div>

    @forelse ($this->myTests as $test)
        <div
            class="block rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800">
            <div class="flex items-start gap-4 p-4 md:p-5">
                <!-- Logo -->
                <div class="shrink-0">
                    <img src="{{ asset('images/include/exam.png') }}" alt="Company Logo"
                        class="size-12 md:size-14 rounded-md object-cover">
                </div>

                <!-- Middle -->
                <div class="min-w-0 flex-1">
                    <!-- Title -->
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 leading-snug dark:text-neutral-100">
                        {{ $test->jobVacancyTest->name }}
                    </h3>
                    <!-- Company & meta line -->
                    <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                        <span class="hidden md:inline">{{ $test->status->getLabel() }}</span>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ \Carbon\Carbon::parse($test->jobVacancyTest->active_from)->isoFormat('dddd, D MMMM Y, HH:mm') }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ \Carbon\Carbon::parse($test->jobVacancyTest->active_until)->isoFormat('dddd, D MMMM Y, HH:mm') }}
                            </span>
                        </div>
                    </div>

                    <!-- Quota -->
                    {{-- <p class="my-2 text-xs text-gray-400 dark:text-neutral-500">Jumlah pelamar saat ini :
                        {{ $test->jobVacancy->tests->count() }}
                    </p> --}}

                    @if (
                        ($test->status == status::assigned ||
                            $test->status == status::in_progress) &&
                            Carbon::parse(now())->lt(Carbon::parse($test->jobVacancyTest->active_until)))
                        <button type='button'
                            class="my-2 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20"
                            aria-haspopup="dialog" aria-expanded="false" aria-controls="verifyTokenModal"
                            data-hs-overlay="#verifyTokenModal">
                            Kerjakan Tes
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
                                @if (Carbon::parse($test->jobVacancyTest->active_until)->isSameDay(now()))
                                    Akan dimulai sekarang
                                @elseif(now()->greaterThan($test->jobVacancyTest->active_until))
                                    Telah selesai
                                @else
                                    Akan dimulai dalam
                                    {{ (int) Carbon::parse(now())->diffInDays(Carbon::parse($test->jobVacancyTest->active_until), false) }}
                                    hari
                                @endif

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                Anda belum memiliki tes untuk dikerjakan
            </h2>

            <!-- Description -->
            <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-neutral-400 text-center">
                Mari mulai perjalanan karier Anda dengan menemukan pekerjaan yang sesuai dengan minat Anda!
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

    <div id="verifyTokenModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
        tabindex="-1" aria-labelledby="verifyTokenModal-label" wire:ignore wire:ignore.self>
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-800">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h3 id="verifyTokenModal-label"
                            class="block text-2xl font-bold text-gray-800 dark:text-neutral-200">Kerjakan Tes</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                            Pastikan anda sudah mendapatkan token
                        </p>
                    </div>

                    <div class="mt-5">
                        <!-- Form -->
                        <form>
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <div class="relative">
                                        <input wire:model='token' type="text" id="token" name="token"
                                            class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                            placeholder="Token">
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                                <!-- End Form Group -->

                                <div class="mt-2 grid space-y-2">
                                    <button type="button"
                                        class="py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        @click="
                                        await $wire.verifyToken;
                                        await $dispatch('closeModal');
                                        ">
                                        Mulai Tes
                                    </button>

                                    <button type="button"
                                        class="py-2.5 px-4 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                        data-hs-overlay="#verifyTokenModal">
                                        Batal
                                    </button>

                                </div>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-molecules.alerts.alert />
    @script
        <script>
            document.addEventListener('closeModal', () => {
                HSOverlay.close('#verifyTokenModal')
            })
        </script>
    @endscript
</div>
