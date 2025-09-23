<main id="content" x-data="{word: 'aaaaaa'}">
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto space-y-4 py-12">
        <div class="relative">
            <input type="text" wire:model.live.debounce.500ms='search'
                class="peer py-2.5 sm:py-3 px-4 ps-11 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                placeholder="Cari lowongan">
            <div
                class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                <svg wire:loading.remove wire:target="search" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>

                <span wire:loading wire:target="search"
                    class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500"
                    role="status" aria-label="loading">
                    <span class="sr-only">Loading...</span>
                </span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row max-w-7xl gap-4">
            <div class="w-full lg:w-1/3">
                <select wire:model.change="jobLevelId"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                    <option value="">--- Level Jabatan ---</option>
                    @foreach ($this->jobLevels as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full lg:w-1/3">
                <select wire:model.change="employeeTypeId"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                    <option value="">--- Jenis Kontrak ---</option>
                    @foreach ($this->employeeTypes as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full lg:w-1/3">
                <select wire:model.change="workTypeId"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                    <option value="">--- Jenis Pekerjaan ---</option>
                    @foreach ($this->workTypes as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto space-y-4 ">
        @foreach ($this->jobs as $job)
            <a href="{{ route('frontend.job.show', $job->slug) }}" wire:navigate
                class="block rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800">
                <div class="flex items-start gap-4 p-4 md:p-5">
                    <!-- Logo -->
                    <div class="shrink-0">
                        <img src="{{ $job->image }}" alt="Company Logo"
                            class="size-12 md:size-14 rounded-md object-cover">
                    </div>

                    <!-- Middle -->
                    <div class="min-w-0 flex-1">
                        <!-- Title -->
                        <h3 class="text-base md:text-lg font-semibold text-gray-800 leading-snug dark:text-neutral-100">
                            {{ $job->title }}
                        </h3>
                        <!-- Company & meta line -->
                        <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                            {{-- <span class="truncate "></span> --}}
                            <span class="hidden md:inline">{!! Str::limit($job->description, 20) !!}</span>
                            <!-- Chips -->
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                    {{ $job->employeeType->name }}
                                </span>
                                <span
                                    class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                    {{ $job->jobLevel->name }}
                                </span>
                                <span
                                    class="inline-flex items-center rounded-md bg-violet-50 px-2 py-1 text-xs font-medium text-violet-700
                        dark:bg-violet-400/10 dark:text-violet-300">
                                    {{ $job->workType->name }}
                                </span>
                            </div>
                        </div>

                        <!-- Quota -->
                        <p class="my-2 text-xs text-gray-400 dark:text-neutral-500">Jumlah pelamar saat ini :
                            {{ $job->applications_count }}</p>

                        @auth
                            @if (in_array($job->id, $applications))
                                <span
                                    class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                    <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                        </path>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    Anda telah melamar
                                </span>
                            @endif
                        @endauth

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
                                        <path
                                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                        </path>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    Berakhir dalam
                                    {{ (int) \Carbon\Carbon::parse(now())->diffInDays(\Carbon\Carbon::parse($job->end_date)) }}
                                    hari
                                </span>
                            </div>
                        </div>

                        @auth
                            <!-- Save / Bookmark -->
                            <button type="button"
                                class="hs-tooltip inline-flex size-9 items-center justify-center rounded-lg
                                    focus:outline-hidden
                                    {{ in_array($job->id, $bookmarks)
                                        ? 'text-yellow-500 hover:bg-yellow-50 dark:text-yellow-400 dark:hover:bg-yellow-400/10'
                                        : 'text-violet-700 hover:bg-violet-50 dark:text-violet-300 dark:hover:bg-violet-400/10' }}"
                                aria-label="Save" @click="$wire.addRemoveJobVacancy('{{ $job->id }}')">
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg"
                                    fill="{{ in_array($job->id, $bookmarks) ? 'currentColor' : 'none' }}"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 4.5A2.5 2.5 0 0 1 7.5 2h9A2.5 2.5 0 0 1 19 4.5v16l-6.5-3.6L6 20.5v-16Z" />
                                </svg>
                            </button>
                        @endauth
                    </div>
                </div>
            </a>
        @endforeach
        {{ $this->jobs->links() }}
    </div>
    <x-molecules.alerts.alert />
</main>
