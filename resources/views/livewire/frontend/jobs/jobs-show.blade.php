<main id="content">
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto space-y-4 py-12">

        <!-- Back link -->
        <a href="{{ route('frontend.job') }}" wire:navigate
            class="inline-flex items-center gap-x-1 text-sm text-violet-600 hover:underline">
            ← Back to Job List
        </a>

        <!-- Banner -->
        <div class="relative w-full rounded-xl overflow-hidden">
            <img src="{{ $JobVacancy->image }}" alt="Banner" class="w-full h-56 object-cover">
            <div class="absolute bottom-4 left-4 bg-white p-3 rounded-lg shadow">
                <img src="{{ $JobVacancy->image }}" class="size-12 md:size-14 rounded-md object-cover">
            </div>
        </div>

        <!-- Title -->
        <div>
            <p class="text-sm text-gray-500 dark:text-neutral-400">Lamar sebelum
                {{ \Carbon\Carbon::parse($JobVacancy->end_date)->format('d F Y') }}</p>
            <h1 class="text-2xl font-bold mt-1">{{ $JobVacancy->title }}</h1>
            <p class="text-gray-500 dark:text-neutral-400 mt-1">
                @foreach ($JobVacancy->placements as $placement)
                    {{ $placement->placement->name }},
                @endforeach
            </p>
        </div>

        <!-- Actions + Tags -->
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex gap-2">
                <div class="hs-tooltip [--placement:top]">
                    <span
                        class="py-2 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                        <img src="{{ Storage::url($JobVacancy->workType->icon) }}" alt="Icon" class="size-5">
                        {{ $JobVacancy->workType->name }}
                        <span
                            class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700"
                            role="tooltip">
                            {{ $JobVacancy->workType->description }}
                        </span>
                    </span>
                </div>
                <div class="hs-tooltip [--placement:top]">
                    <span
                        class="py-2 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                        <img src="{{ Storage::url($JobVacancy->employeeType->icon) }}" alt="Icon" class="size-5">
                        {{ $JobVacancy->employeeType->name }}
                        <span
                            class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700"
                            role="tooltip">
                            {{ $JobVacancy->employeeType->description }}
                        </span>
                    </span>
                </div>
                <div class="hs-tooltip [--placement:top]">
                    <span
                        class="py-2 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                        <img src="{{ Storage::url($JobVacancy->jobLevel->icon) }}" alt="Icon" class="size-5">
                        {{ $JobVacancy->jobLevel->name }}
                        <span
                            class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700"
                            role="tooltip">
                            {{ $JobVacancy->jobLevel->description }}
                        </span>
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                @auth
                    <button type="button"
                        class="{{ $this->saved
                            ? 'text-amber-600 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-400/10'
                            : 'text-amber-800 hover:bg-amber-200 dark:text-amber-300 dark:hover:bg-amber-800/30' }}
                        py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent
                        bg-amber-100 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:bg-amber-900/30"
                        @click="$wire.addRemoveJobVacancyBookmark('{{ $JobVacancy->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                        </svg>
                        {{ $this->saved ? 'Tersimpan' : 'Simpan' }}
                    </button>

                    <button type="button" @disabled($this->applied) aria-haspopup="dialog" aria-expanded="false"
                        aria-controls="applyJobModal" data-hs-overlay="#applyJobModal"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check">
                            <path
                                d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                        {{ $this->applied ? 'Lamaran Terkirim' : 'Lamar Sekarang' }}
                    </button>
                @endauth

                <button disabled
                    class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-200 text-gray-600 text-sm">
                    {{ $JobVacancy->status === 1 ? 'Terbuka' : 'Tertutup' }}
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-8 lg:col-span-8">
                <div
                    class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-sm p-6 space-y-8">
                    <!-- Job Description -->
                    <section>
                        <h2 class="text-lg font-semibold mb-2">Deskripsi Pekerjaan</h2>
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-neutral-300">
                            {!! $JobVacancy->description !!}
                        </p>
                    </section>

                    <!-- Requirements -->
                    <section>
                        <h2 class="text-lg font-semibold mb-2">Persyaratan</h2>
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-neutral-300">
                            {!! $JobVacancy->requirements !!}
                        </p>
                    </section>
                </div>
            </div>

            <div class="col-span-12 md:col-span-4 lg:col-span-4">
                <div
                    class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-sm p-6 space-y-8">
                    <h2 class="text-lg font-semibold mb-2">Tunjangan dan Manfaat</h2>
                    <div class="max-w-full flex flex-col">
                        @foreach ($JobVacancy->benefits as $benefit)
                            <button type="button"
                                class="inline-flex items-center gap-x-2 py-3 px-4 text-sm text-start font-medium text-blue-600 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700">
                                <img src="{{ Storage::url($benefit->benefitCategory->icon) }}" alt="Icon"
                                    class="size-5 me-2">
                                {{ $benefit->benefitCategory->name }} - {{ $benefit->description }}
                            </button>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-molecules.alerts.alert />

    <div id="applyJobModal" wire:ignore wire:ignore.self
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
        tabindex="-1" aria-labelledby="applyJobModal-label">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-900">
                <div class="absolute top-2 end-2">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#applyJobModal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
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
                        Peringatan
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-500">
                        Sebelum lowongan ditutup, anda dapat membatalkan lamaran anda kapan saja. Namun, anda tidak
                        dapat membatalkan nya ketika lamaran sudah ditutup, apakah anda yakin ingin melamar pada
                        lowongan ini?
                    </p>

                    <div class="mt-6 flex justify-center gap-x-4">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="$wire.apply('{{ $JobVacancy->id }}')">
                            Ya, Lamar
                        </button>
                        <button type="button"
                            class=" py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                            data-hs-overlay="#hs-sign-out-alert">
                            Tidak, Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            document.addEventListener('closeModal', () => {
                HSOverlay.close('#applyJobModal')
            })
        </script>
    @endscript
</main>
