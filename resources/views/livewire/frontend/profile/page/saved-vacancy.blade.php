<div class=" col-span-full md:col-span-full lg:col-span-9 space-y-4">
    <div
        class="col-span-full md:col-span-full lg:col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
        <strong>
            <h2 class="text-3xl text-gray-800 dark:text-slate-100">Lowongan Tersimpan</h2>
        </strong>
    </div>

    @forelse ($this->savedVacancies as $savedVacancy)
        <a href="{{ route('frontend.job.show', $savedVacancy->jobVacancy->slug) }}"
            class="block rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800">
            <div class="flex items-start gap-4 p-4 md:p-5">
                <!-- Logo -->
                <div class="shrink-0">
                    <img src="{{ $savedVacancy->jobVacancy->image }}" alt="Company Logo"
                        class="size-12 md:size-14 rounded-md object-cover">
                </div>

                <!-- Middle -->
                <div class="min-w-0 flex-1">
                    <!-- Title -->
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 leading-snug dark:text-neutral-100">
                        {{ $savedVacancy->jobVacancy->title }}
                    </h3>
                    <!-- Company & meta line -->
                    <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                        {{-- <span class="truncate "></span> --}}
                        <span class="hidden md:inline">{!! Str::limit($savedVacancy->jobVacancy->description, 20) !!}</span>
                        <!-- Chips -->
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ $savedVacancy->jobVacancy->employeeType->name }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ $savedVacancy->jobVacancy->jobLevel->name }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                {{ $savedVacancy->jobVacancy->workType->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Quota -->
                    <p class="my-2 text-xs text-gray-400 dark:text-neutral-500">Jumlah pelamar saat ini :
                        {{ $savedVacancy->jobVacancy->applications->count() }}</p>

                    @if (in_array($savedVacancy->jobVacancy->id, $applications))
                        <span
                            class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                            <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                </path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            Anda telah melamar
                        </span>
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
                                Berakhir dalam
                                {{ (int) \Carbon\Carbon::parse(now())->diffInDays(\Carbon\Carbon::parse($savedVacancy->jobVacancy->end_date)) }}
                                hari
                            </span>
                        </div>
                    </div>

                    <!-- Save / Bookmark -->
                    <button type="button"
                        class="hs-tooltip inline-flex size-9 items-center justify-center rounded-lg
                                    focus:outline-hidden
                                    text-yellow-500 hover:bg-yellow-50 dark:text-yellow-400 dark:hover:bg-yellow-400/10"
                        aria-label="Save" @click="$wire.removeBookmark('{{ $savedVacancy->id }}')">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 4.5A2.5 2.5 0 0 1 7.5 2h9A2.5 2.5 0 0 1 19 4.5v16l-6.5-3.6L6 20.5v-16Z" />
                        </svg>
                    </button>

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
                Tidak Ada Pekerjaan yang Tersimpan
            </h2>

            <!-- Description -->
            <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-neutral-400 text-center">
                Anda belum menyimpan lowongan pekerjaan apa pun. Mari mulai perjalanan karier Anda dengan menemukan
                pekerjaan yang sesuai dengan minat Anda!
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
    {{ $this->savedVacancies->links() }}
    <x-molecules.alerts.alert />

</div>
