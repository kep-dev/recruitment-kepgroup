<div>
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content">
        <!-- Hero -->
        <div class="px-4 sm:px-6 lg:px-8 ">
            <div class="h-120 md:h-[80dvh] flex flex-col bg-center bg-no-repeat bg-cover rounded-2xl"
                style="background-image: url({{ asset('images/include/bgjdih.jpg') }})">
                <div class="mt-auto w-2/3 md:max-w-lg ps-5 pb-5 md:ps-10 md:pb-10">
                    <h1 class="text-xl md:text-3xl lg:text-5xl text-white">
                        Recruitment KEP Group
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Hero -->

        <!-- Works -->
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
            <div class="mb-6 sm:mb-10 max-w-2xl text-center mx-auto">
                <h1 class="font-medium text-black text-3xl sm:text-4xl dark:text-white">
                    Lowongan Kerja Terbaru
                </h1>
            </div>

            <!-- Card Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Card -->
                @forelse ($this->jobVacancies as $jobVacancy)
                    <div class="group flex flex-col">
                        <div class="relative">
                            <div class="aspect-4/4 overflow-hidden rounded-2xl">
                                <img class="size-full object-cover rounded-2xl"
                                    src="{{ Storage::disk('public')->url($jobVacancy->image) }}" alt="Thumbnail">
                            </div>

                            <div class="pt-4">
                                <h2 class="font-medium md:text-lg text-black dark:text-white">
                                    {{ $jobVacancy->title }}
                                </h2>

                                <p class="mt-2 font-semibold text-black dark:text-white">
                                    {{ $jobVacancy->end_date->format('d F Y') }}
                                </p>
                            </div>

                            <a class="after:absolute after:inset-0 after:z-1" href="#"></a>
                        </div>

                        <div class="mb-2 mt-4 text-sm">
                            <div class="flex flex-col">
                                <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium text-black dark:text-white">Jenis Pekerjaan</span>
                                        </div>
                                        <div class="text-end">
                                            <span
                                                class="text-black dark:text-white">{{ $jobVacancy->workType->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium text-black dark:text-white">Level Pekerjaan</span>
                                        </div>
                                        <div class="text-end">
                                            <span
                                                class="text-black dark:text-white">{{ $jobVacancy->employeeType->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium text-black dark:text-white">Status Karyawan</span>
                                        </div>
                                        <div class="flex justify-end">
                                            <span
                                                class="text-black dark:text-white">{{ $jobVacancy->jobLevel->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none"
                                href="{{ route('frontend.job.show', $jobVacancy->slug) }}" wire:navigate>
                                Lihat Lowongan
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Empty State (spans full width) -->
                    <div class="col-span-full">
                        <div
                            class="flex flex-col items-center justify-center text-center p-10 rounded-2xl border border-dashed border-gray-300 dark:border-neutral-700 bg-white/60 dark:bg-neutral-900/40">
                            <!-- Icon -->
                            <div
                                class="mb-4 inline-flex items-center justify-center size-16 rounded-2xl bg-gray-100 dark:bg-neutral-800">
                                <!-- simple SVG icon -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-8 text-gray-600 dark:text-neutral-300" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 7v10a2 2 0 0 0 2 2h5m11-8v6a2 2 0 0 1-2 2h-7m9-12V7M7 7h10M7 11h6" />
                                </svg>
                            </div>

                            <h3 class="text-base/6 font-semibold text-gray-900 dark:text-white">
                                Belum ada lowongan tersedia
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-neutral-300 max-w-md">
                                Saat ini tidak ada pekerjaan yang diposting. Silakan kembali lagi nanti atau buat
                                lowongan baru.
                            </p>

                            <div class="mt-6 flex items-center gap-3">
                                {{-- tombol opsional, sesuaikan rutenya --}}
                                <a href="{{ route('job-vacancies.create') }}"
                                    class="inline-flex items-center gap-x-2 rounded-xl px-4 py-2 text-sm font-medium bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition">
                                    Tambah Lowongan
                                </a>
                                <button type="button" data-hs-overlay="#filter-lowongan"
                                    class="inline-flex items-center gap-x-2 rounded-xl px-4 py-2 text-sm font-medium border border-gray-300 dark:border-neutral-700 text-gray-700 dark:text-neutral-200 hover:bg-gray-50 dark:hover:bg-neutral-800">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /Empty State -->
                @endforelse
                <!-- End Card -->
            </div>

            <!-- Contoh Preline Overlay untuk filter (opsional) -->
            {{-- <div id="filter-lowongan"
                class="hs-overlay hs-overlay-open:mt-0 hidden fixed top-0 start-0 size-full z-[60] overflow-y-auto">
                <div class="m-3 sm:mx-auto sm:w-full sm:max-w-lg">
                    <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow p-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white">Filter Lowongan</h4>
                            <button type="button"
                                class="size-8 inline-flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-800"
                                data-hs-overlay="#filter-lowongan">
                                <span class="sr-only">Close</span>
                                ✕
                            </button>
                        </div>
                        <div class="mt-5 space-y-4">
                            <!-- isi filter kamu -->
                            <input type="text" class="w-full rounded-xl border-gray-300 dark:border-neutral-700"
                                placeholder="Cari posisi…">
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                class="px-4 py-2 rounded-xl border border-gray-300 dark:border-neutral-700">Reset</button>
                            <button
                                class="px-4 py-2 rounded-xl bg-yellow-400 text-black hover:bg-yellow-500">Terapkan</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- End Card Grid -->

            <div class="mt-10 lg:mt-20 text-center">
                <a class="relative inline-block font-medium md:text-lg text-black before:absolute before:bottom-0.5 before:start-0 before:-z-1 before:w-full before:h-1 before:bg-yellow-400 hover:before:bg-black focus:outline-hidden focus:before:bg-black dark:text-white dark:hover:before:bg-white dark:focus:before:bg-white"
                    href="{{ route('frontend.job') }}" wire:navigate>
                    Lihat Semua Lowongan
                </a>
            </div>
        </div>
        <!-- End Works -->

        <!-- Testimonials -->
        <div class="py-10 md:py-16 lg:py-20 bg-orange-100">
            <div class="px-4 sm:px-6 lg:px-8">
                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 md:items-center">
                    <div class="relative h-80 md:h-150 bg-gray-100 rounded-2xl dark:bg-neutral-800">
                        <img class="absolute inset-0 size-full object-cover rounded-2xl"
                            src="{{ asset('images/include/generated-image.png') }}" alt="Testimonials Image">
                    </div>
                    <!-- End Col -->

                    <div class="pt-10 md:p-10">
                        <blockquote class="max-w-4xl mx-auto">
                            <p class="mb-6 md:text-lg">
                                Bergabunglah dengan tim yang menyalakan kemajuan dengan disiplin keselamatan dan
                                teknologi terbaik.
                            </p>

                            <p class="text-xl sm:text-2xl lg:text-3xl lg:leading-normal text-gray-800">
                                Setiap kilowatt yang dihasilkan adalah hasil kolaborasi, disiplin, dan inovasi. Tim
                                beragam keahlian memastikan operasi aman, stabil, dan efisien, mengalirkan daya untuk
                                rumah, bisnis, dan industri. Bergabung untuk tumbuh, berkontribusi pada energi yang
                                lebih bersih, dan membangun karier yang berarti bagi diri sendiri dan negeri.
                            </p>

                            {{-- <footer class="mt-6 md:mt-10">
                                <div class="border-neutral-700">
                                    <button type="button"
                                        class="group inline-flex items-center gap-x-3 text-gray-800 dark:text-neutral-200 text-sm focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                                        <span
                                            class="size-8 md:size-10 flex flex-col justify-center items-center bg-black text-white rounded-full group-hover:scale-105 group-focus:scale-105 transition-transform duration-300 ease-in-out dark:bg-white dark:text-black">
                                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393" />
                                            </svg>
                                        </span>
                                        Watch the Video
                                    </button>
                                </div>
                            </footer> --}}
                        </blockquote>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Grid -->
            </div>
        </div>
        <!-- End Testimonials -->

        <!-- Contact -->
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
            <div class="mb-6 sm:mb-10 max-w-2xl text-center mx-auto">
                <h2 class="font-medium text-black text-2xl sm:text-4xl dark:text-white">
                    Contacts
                </h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 lg:items-center gap-6 md:gap-8 lg:gap-12">
                <div
                    class="aspect-w-16 aspect-h-6 lg:aspect-h-14 overflow-hidden bg-gray-100 rounded-2xl dark:bg-neutral-800">
                    <img class="group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out object-cover rounded-2xl"
                        src="{{ asset('images/include/generated-image-2.png') }}" alt="Contacts Image">
                </div>
                <!-- End Col -->

                <div class="space-y-8 lg:space-y-16">
                    <div>
                        <h3 class="mb-5 font-semibold text-black dark:text-white">
                            Alamat Kami
                        </h3>

                        <!-- Grid -->
                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 md:gap-8 lg:gap-12">
                            <div class="flex gap-4">
                                <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>

                                <div class="grow">
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        Surabaya,
                                    </p>
                                    <address class="mt-1 text-black not-italic dark:text-white">
                                        Jl. Walikota Mustajab No.76, 60272
                                    </address>
                                </div>
                            </div>
                        </div>
                        <!-- End Grid -->
                    </div>

                    <div>
                        <h3 class="mb-5 font-semibold text-black dark:text-white">
                            Kontak Kami
                        </h3>

                        <!-- Grid -->
                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 md:gap-8 lg:gap-12">
                            <div class="flex gap-4">
                                <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z">
                                    </path>
                                    <path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"></path>
                                </svg>

                                <div class="grow">
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        Email
                                    </p>
                                    <p>
                                        <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-1 before:w-full before:h-1 before:bg-yellow-400 hover:before:bg-black focus:outline-hidden focus:before:bg-black dark:text-white dark:hover:before:bg-white dark:focus:before:bg-white"
                                            href="mailto:cfk@kepgroup.id">
                                            cfk@kepgroup.id
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>

                                <div class="grow">
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        Hubungi Kami
                                    </p>
                                    <p>
                                        <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-1 before:w-full before:h-1 before:bg-yellow-400 hover:before:bg-black focus:outline-hidden focus:before:bg-black dark:text-white dark:hover:before:bg-white dark:focus:before:bg-white"
                                            href="mailto:example@site.so">
                                            (0542) 748436
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- End Grid -->
                    </div>
                </div>
                <!-- End Col -->
            </div>
        </div>
        <!-- End Contact -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

</div>
