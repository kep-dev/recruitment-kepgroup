<!-- Pricing -->
<div class="w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">{{ $JobVacancyTest->name }}</h2>
        <p class="mt-1 text-gray-600 dark:text-neutral-400">{{ $JobVacancyTest->jobVacancy->title }}</p>
    </div>
    <!-- End Title -->

    @if (session('test_alert'))
        <div class="mt-2 mb-3 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500"
            role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
            <span id="hs-soft-color-danger-label" class="font-bold">Pemberitahuan</span> {{ session('test_alert') }}
        </div>
    @endif

    <div x-data="{ dismissed: false }" x-show="!dismissed" x-cloak
        class="bg-white border border-gray-200 dark:bg-neutral-900 dark:border-neutral-700 text-sm text-yellow-800 rounded-lg p-4 dark:text-yellow-300 mb-4"
        role="alert" tabindex="-1" aria-labelledby="exam-rules-label">
        <div class="flex gap-3">
            <div class="shrink-0">
                <!-- friendly warning icon -->
                <svg class="w-6 h-6 text-yellow-700 dark:text-yellow-300" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                    </path>
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 9v4"></path>
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 17h.01"></path>
                </svg>
            </div>

            <div class="flex-1">
                <h3 id="exam-rules-label" class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">
                    Peraturan Ujian — Harap Dibaca Sebelum Memulai
                </h3>

                <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                    Agar ujian berjalan adil dan valid, mohon patuhi aturan berikut. Pelanggaran dapat berakibat
                    peringatan otomatis, pembatalan hasil, atau diskualifikasi.
                </p>

                <ul class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3">
                            </path>
                        </svg>
                        <div>
                            <strong class="block">Jangan berpindah tab/jendela</strong>
                            Jangan membuka tab/jendela lain untuk mencari jawaban.
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6M9 16h6M9 8h6"></path>
                        </svg>
                        <div>
                            <strong class="block">Tidak menyalin soal</strong>
                            Dilarang menyalin/menyimpan pertanyaan ke aplikasi lain (copy/paste/screenshot).
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10l4.553-2.276A2 2 0 0122 9.618V14a2 2 0 01-1.553 1.894L15 18v-8zM3 7v10a2 2 0 002 2h8">
                            </path>
                        </svg>
                        <div>
                            <strong class="block">Jangan rekam atau foto layar</strong>
                            Mengambil screenshot atau merekam layar selama tes tidak diperbolehkan.
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7h4l3 9h8l3-9h4"></path>
                        </svg>
                        <div>
                            <strong class="block">Gunakan satu perangkat</strong>
                            Dilarang menggunakan perangkat lain (HP/laptop lain) untuk membantu selama tes.
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                d="M12 2l2 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"></path>
                        </svg>
                        <div>
                            <strong class="block">Jangan manipulasi halaman</strong>
                            Dilarang membuka DevTools, mengubah skrip, atau memanipulasi DOM untuk keuntungan.
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8"></path>
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 3v1"></path>
                        </svg>
                        <div>
                            <strong class="block">Jangan refresh untuk menambah waktu</strong>
                            Waktu ujian dikontrol server. Refresh tidak akan menambah durasi ujian.
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 11V7">
                            </path>
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 7v10">
                            </path>
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 11v6">
                            </path>
                        </svg>
                        <div>
                            <strong class="block">Sesi tunggal per peserta</strong>
                            Satu akun hanya boleh aktif pada satu sesi. Multi-login akan otomatis diblokir.
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-700 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5h18M3 12h18M3 19h18"></path>
                        </svg>
                        <div>
                            <strong class="block">Dilarang menggunakan bot/skrip</strong>
                            Sistem kami memantau pola jawaban; tindakan otomatis (bot) akan terdeteksi dan diblokir.
                        </div>
                    </li>
                </ul>

                <div class="mt-4 flex items-center gap-3">
                    <button type="button" x-on:click="dismissed = true; $dispatch('exam-acknowledged')"
                        class="px-3 py-2 rounded-lg bg-yellow-700 text-white text-sm font-medium hover:bg-yellow-600 focus:outline-none">
                        Saya Mengerti
                    </button>

                    <button type="button" x-on:click="$dispatch('open-help')"
                        class="px-3 py-2 rounded-lg bg-white border border-yellow-200 text-yellow-800 text-sm hover:bg-yellow-50 focus:outline-none">
                        Butuh Bantuan?
                    </button>

                    <div class="ms-auto text-xs text-yellow-700 dark:text-yellow-300">
                        <strong>Catatan:</strong> Semua aktivitas direkam untuk audit.
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Grid -->
    {{-- <div
        class="mt-12 grid sm:grid-cols-1 lg:grid-cols-{{ $JobVacancyTest->jobVacancyTestItems->count() }} gap-4 lg:items-center">
        @foreach ($this->testItems as $jobVacancyTestItem)
            <div
                class="flex flex-col border bg-white border-gray-200 text-center rounded-xl p-8 dark:border-neutral-800 dark:bg-neutral-800">
                <h4 class="font-medium text-lg text-gray-800 dark:text-neutral-200">Paket</h4>
                <span
                    class="mt-7 font-bold text-3xl text-gray-800 dark:text-neutral-200">{{ $jobVacancyTestItem->test->title }}</span>
                <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $jobVacancyTestItem->test->description }}
                </p>

                <ul class="mt-7 space-y-2.5 text-sm flex flex-col items-center">
                    <li class="flex gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.0" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-timer-icon lucide-timer text-blue-500 dark:text-blue-600">
                            <line x1="10" x2="14" y1="2" y2="2" />
                            <line x1="12" x2="15" y1="14" y2="11" />
                            <circle cx="12" cy="14" r="8" />
                        </svg>
                        <span class="text-gray-800 dark:text-neutral-400">
                            {{ $jobVacancyTestItem->duration_in_minutes }} Menit
                        </span>
                    </li>

                    <li class="flex gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-notebook-pen-icon lucide-notebook-pen text-blue-500 dark:text-blue-600">
                            <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                            <path d="M2 6h4" />
                            <path d="M2 10h4" />
                            <path d="M2 14h4" />
                            <path d="M2 18h4" />
                            <path
                                d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        </svg>
                        <span class="text-gray-800 dark:text-neutral-400">
                            {{ $jobVacancyTestItem->number_of_question }} Soal
                        </span>
                    </li>
                </ul>
                <button type="button"
                    class="mt-5 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20"
                    @click="$wire.startAttemptByToken('{{ $jobVacancyTestItem->id }}')">
                    <span wire:loading.remove>
                        Mulai
                    </span>
                    <span wire:loading>
                        Memuat soal anda....
                    </span>
                </button>
            </div>
        @endforeach
    </div> --}}
    <!-- End Card Grid -->

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($this->testItems as $jobVacancyTestItem)
            <div
                class="flex flex-col rounded-xl p-4 md:p-6 bg-white border border-gray-200 dark:bg-neutral-900 dark:border-neutral-700">
                <div class="flex items-center gap-x-4">
                    <img class="rounded-full size-20" src="{{ asset('images/include/test.png') }}" alt="Avatar">
                    <div class="grow">

                        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                            Soal
                        </p>
                        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                            No. Urut : {{ $jobVacancyTestItem->order }}
                        </p>
                        <h3 class="font-medium text-gray-800 dark:text-neutral-200 text-uppercase">
                            {{ $jobVacancyTestItem->test->title }}
                        </h3>
                    </div>
                </div>

                <p class="mt-3 text-gray-500 dark:text-neutral-500">
                    {{ $jobVacancyTestItem->test->description }}
                </p>

                <!-- Social Brands -->
                <div class="mt-3 space-x-1">
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                        <span
                            class="inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-500 text-white">{{ $jobVacancyTestItem->duration_in_minutes }}</span>
                        Menit
                    </button>
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                        <span
                            class="inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-500 text-white">{{ $jobVacancyTestItem->number_of_question }}</span>
                        Soal
                    </button>
                    <button type="button" @disabled(in_array($jobVacancyTestItem->id, $applicantTestAttempts))
                        class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20"
                        @click="$wire.startAttemptByToken('{{ $jobVacancyTestItem->id }}')">
                        <span wire:loading.remove>
                            Mulai Kerjakan
                        </span>
                        <span wire:loading>
                            Memuat soal anda....
                        </span>
                    </button>
                </div>
                <!-- End Social Brands -->
            </div>
        @endforeach
        <!-- End Col -->
    </div>

    <div class="col-span-12">
        <button type="button"
            class="mt-4 py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-hidden focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20"
            aria-haspopup="dialog" aria-expanded="false" aria-controls="end-test-alert"
            data-hs-overlay="#end-test-alert">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban">
                    <path d="M4.929 4.929 19.07 19.071" />
                    <circle cx="12" cy="12" r="10" />
                </svg>
            </span>
            Akhiri Test
        </button>
    </div>

    <!-- End Grid -->

    <div id="end-test-alert"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
        tabindex="-1" aria-labelledby="end-test-alert-label">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-900">
                <div class="absolute top-2 end-2">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#end-test-alert">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

                    <h3 id="end-test-alert-label" class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200">
                        Akhiri Test
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-500">
                        Anda yakin ingin menyelesaikan test? Pastikan anda telah menyelesaikan semua test sebelumnya.
                    </p>

                    <div class="mt-6 flex justify-center gap-x-4">
                        <button type="button" x-data
                            @click="
                                $wire.endTest();
                                setTimeout(() => {
                                    if (window.opener) {
                                        window.close();
                                    } else {

                                    }
                                }, 500);
                            "
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                            Ya, Akhiri
                        </button>
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            data-hs-overlay="#end-test-alert">
                            Tidak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Grid -->
    <x-molecules.alerts.alert />

    <script>
        document.addEventListener('alpine:init', () => {
            window.addEventListener('open-exam-tab', (e) => {
                const url = e.detail.url;

                // Buka jendela baru fullscreen-like
                const feat = [
                    'popup=yes',
                    `width=${screen.availWidth}`,
                    `height=${screen.availHeight}`,
                    'top=0',
                    'left=0',
                    'resizable=no',
                    'scrollbars=no',
                    'menubar=no',
                    'toolbar=no',
                    'status=no'
                ].join(',');

                const examWin = window.open(url, '_blank', feat);

                if (examWin) {
                    examWin.focus();

                    // Minta halaman ujian ikut fullscreen
                    const channel = new BroadcastChannel('exam_channel');
                    channel.postMessage({
                        type: 'request-fullscreen'
                    });

                    // Fallback: minta fullscreen di halaman sekarang (jika diizinkan)
                    const el = document.documentElement;
                    (el.requestFullscreen?.bind(el) ?? el.webkitRequestFullscreen?.bind(el))?.().catch(
                        () => {});
                } else {
                    alert('Pop-up diblokir. Mohon izinkan pop-up untuk memulai tes.');
                }
            });
        });
    </script>

</div>
<!-- End Pricing -->
