<div>
    <!-- ========== MAIN CONTENT ========== -->
    <main class="w-full max-w-7xl md:pt-0 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-9 gap-4">
            @include('profile.side-profile')
            <div
                class="col-start-4 col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <strong>
                    <h2 class="text-3xl text-gray-800 dark:text-slate-100">My Profile</h2>
                </strong>
            </div>

            {{-- <div
                class="col-start-4 col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <h4 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-6">Availability</h4>
                <div class="flex justify-between">
                    <span class="justify-start text-gray-800 dark:text-slate-100">I am open for job opportunities</span>
                    <label for="hs-basic-usage" class="relative inline-block w-11 h-6 cursor-pointer justify-end">
                        <input type="checkbox" id="hs-basic-usage" class="peer sr-only">
                        <span
                            class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                        <span
                            class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                    </label>
                </div>
            </div> --}}

            {{-- Informasi Pribadi --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                            Informasi Pribadi
                        </h3>

                        <div class="flex items-center gap-x-3">
                            <!-- Eye -->
                            <button type="button" class="text-purple-600 hover:text-purple-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                            <!-- Pencil -->
                            <button type="button" class="text-purple-600 hover:text-purple-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-5 md:p-6">
                        <!-- Avatar di ATAS tulisan -->
                        <img src="{{ asset('images/include/powerplants.jpg') }}" alt="Avatar" class="rounded-full"
                            style="width:100px; height:100px; object-fit:cover" />

                        <!-- Grid informasi -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-6">
                            <!-- Name -->
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Name</p>
                                <p class="mt-1 text-gray-700 dark:text-slate-200">Muhammad Ridho Prasetyo</p>
                            </div>

                            <!-- NIK -->
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">NIK</p>
                                <p class="mt-1 text-gray-700 dark:text-slate-200">*****</p>
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Date of Birth</p>
                                <p class="mt-1 text-gray-700 dark:text-slate-200">*****</p>
                            </div>

                            <!-- Gender -->
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Gender</p>
                                <p class="mt-1 text-gray-700 dark:text-slate-200">Male</p>
                            </div>

                            <!-- Location -->
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Location</p>
                                <p class="mt-1 text-gray-700 dark:text-slate-200">Kabupaten Kutai Kartanegara</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Phone</p>
                                <p class="mt-1 text-gray-700 dark:text-slate-200">*****</p>
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-2">
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Email</p>
                                <div class="mt-1 inline-flex items-center gap-2">
                                    <span class="text-gray-700 dark:text-slate-200">muhammadridho228@gmail.com</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                </div>
                            </div>

                            <!-- LinkedIn -->
                            <div class="sm:col-span-2">
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Linkedin Profile</p>
                                <a href="#"
                                    class="mt-1 inline-flex items-center gap-2 text-indigo-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M4.98 3.5A2.5 2.5 0 1 0 5 8.5a2.5 2.5 0 0 0-.02-5ZM4 9h2.9v12H4Zm5.48 0H13v1.64h.04a3.2 3.2 0 0 1 2.88-1.58c3.08 0 3.65 2.03 3.65 4.68V21H16.7v-5.27c0-1.26-.02-2.88-1.76-2.88-1.77 0-2.04 1.38-2.04 2.79V21H9.48Z" />
                                    </svg>
                                    Muhammad Ridho Prasetyo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Informasi Pribadi --}}

            {{-- Professional Headline --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl">
                    <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                            Professional Headline
                        </h3>

                        <div class="flex items-center gap-x-1">
                            <div class="hs-tooltip inline-block">
                                <button type="button"
                                    class="hs-tooltip-toggle size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                    <span
                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs"
                                        role="tooltip">
                                        Edit Data
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Professional Headline --}}

            {{-- Pendidikan Terakhir --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                            Pendidikan Terakhir
                        </h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                            Tambah Pendidikan Terakhir
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-4 md:p-5 space-y-2">
                        <div class="flex items-start justify-between gap-4">
                            <!-- Left Content -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <p class="font-semibold text-gray-800 dark:text-slate-200">
                                        Sekolah Tinggi Manajemen Informatika Dan Komputer Widya Cipta Dharma
                                    </p>
                                    <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        2023
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">
                                    S1, Teknik Informatika, GPA: 3.61
                                </p>
                            </div>

                            <!-- Right Action Buttons -->
                            <div class="flex items-center gap-3 shrink-0">
                                <!-- Edit -->
                                <button class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                <!-- Delete -->
                                <button class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash2-icon lucide-trash-2">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pendidikan Terakhir --}}

            {{-- Years of Full-time Work Experience --}}
            <div class="col-start-4 col-span-9">
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
            </div>
            {{-- Years of Full-time Work Experience --}}

            {{-- Pengalaman Kerja --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">Pengalaman Kerja</h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                            Tambah Pengalaman Kerja
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-4 md:p-5">
                        <div class="space-y-6">

                            <!-- Item 1 -->
                            <div>
                                <div class="flex items-start justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3">
                                            <p class="font-semibold text-gray-800 dark:text-slate-200">Senior Staff IT
                                            </p>
                                            <span
                                                class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                                                Nov 2023 – Present
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 dark:text-slate-400">
                                            PT. Cahaya Fajar Kaltim
                                            <span class="mx-1">·</span> Web Developer
                                            <span class="mx-1">·</span> Energy Supply
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-3 shrink-0">
                                        <!-- Edit -->
                                        <button class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-pencil-icon lucide-pencil">
                                                <path
                                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button>
                                        <!-- Delete -->
                                        <button class="text-red-600 hover:text-red-800" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash2-icon lucide-trash-2">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <p class="mt-2 text-[15px] leading-relaxed text-gray-700 dark:text-slate-300">
                                    mengembangkan dan memelihara sistem ERP internal perusahaan yang disesuaikan dengan
                                    kebutuhan operasional setiap departemen. Sistem ini saya bangun menggunakan
                                    framework
                                    Laravel, serta teknologi pendukung seperti Livewire dan Alpine.js untuk menciptakan
                                    aplikasi
                                    web yang dinamis dan responsif.
                                </p>

                                <!-- Divider -->
                                <div class="my-4 border-t border-gray-200 dark:border-white/10"></div>
                            </div>

                            <!-- Item 2 -->
                            <div>
                                <div class="flex items-start justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3">
                                            <p class="font-semibold text-gray-800 dark:text-slate-200">Staff Umum</p>
                                            <span
                                                class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                                                Jan 2020 – Nov 2023
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 dark:text-slate-400">
                                            Pemerintahan Desa Manunggal Jaya
                                            <span class="mx-1">·</span> Graphic Designer
                                            <span class="mx-1">·</span> Government and Public Administration
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-3 shrink-0">
                                        <button class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-pencil-icon lucide-pencil">
                                                <path
                                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash2-icon lucide-trash-2">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <ul class="mt-2 space-y-1 text-[15px] text-gray-700 dark:text-slate-300">
                                    <li>- Menyiapkan segala material untuk diubah ke dalam bentuk visual</li>
                                    <li>- Membuat desain infografis banner, poster dan infografis</li>
                                    <li>- Menulis konten berita terbaru pada website maupun sosial media Pemerintah Desa
                                        Manunggal Jaya tentang kegiatan-kegiatan yang dilakukan</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengalaman Kerja --}}

            {{-- Pengalaman Organisasi --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                            Pengalaman Organisasi
                        </h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                            Tambah Pengalaman Organisasi
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-4 md:p-5 space-y-2">
                        <div class="flex items-start justify-between gap-4">
                            <!-- Left Content -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <p class="font-semibold text-gray-800 dark:text-slate-200">
                                        Humas
                                    </p>
                                    <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        Jan 2018 – Dec 2020
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">
                                    HiMa-TI
                                </p>
                            </div>

                            <!-- Right Action Buttons -->
                            <div class="flex items-center gap-3 shrink-0">
                                <!-- Edit -->
                                <button class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                <!-- Delete -->
                                <button class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pengalaman Organisasi --}}

            {{-- Pelatihan & Sertifikasi --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                            Pelatihan & Sertifikasi
                        </h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                            Tambah Pelatihan & Sertifikasi
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-4 md:p-5 space-y-2">
                        <div class="flex items-start justify-between gap-4">
                            <!-- Left Content -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <p class="font-semibold text-gray-800 dark:text-slate-200">
                                        Junior Web Developer
                                    </p>
                                    <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        Aug 2019 – Sep 2019
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">
                                    Kominfo
                                </p>
                            </div>

                            <!-- Right Action Buttons -->
                            <div class="flex items-center gap-3 shrink-0">
                                <!-- Edit -->
                                <button class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                <!-- Delete -->
                                <button class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Description -->
                        <ul
                            class="mt-2 space-y-1 text-[15px] leading-relaxed text-gray-700 dark:text-slate-300 list-disc list-inside">
                            <li>Mengimplementasikan pemrograman berorientasi objek</li>
                            <li>Mengimplementasikan algoritma pemrograman</li>
                            <li>Menggunakan struktur data</li>
                            <li>Melakukan debugging</li>
                            <li>Mengimplementasikan user interface</li>
                            <li>Menerapkan perintah eksekusi bahasa pemrograman berbasis teks, grafik, dan multimedia
                            </li>
                            <li>Menyusun fungsi, file atau sumber daya pemrograman lain dalam organisasi yang rapi</li>
                            <li>Menulis kode dengan prinsip sesuai guidelines dan best practices</li>
                            <li>Mengimplementasikan pemrograman terstruktur</li>
                            <li>Menggunakan library atau komponen pre-existing</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Pelatihan & Sertifikasi --}}

            {{-- Penghargaan --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                            Penghargaan
                        </h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                            Tambah Penghargaan
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-4 md:p-5 space-y-2">
                        <div class="flex items-start justify-between gap-4">
                            <!-- Left Content -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <p class="font-semibold text-gray-800 dark:text-slate-200">
                                        Juara 1
                                    </p>
                                    <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        2020
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">
                                    Lomba
                                </p>
                            </div>

                            <!-- Right Action Buttons -->
                            <div class="flex items-center gap-3 shrink-0">
                                <!-- Edit -->
                                <button class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                <!-- Delete -->
                                <button class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Penghargaan --}}

            {{-- Bahasa --}}
            <div class="col-start-4 col-span-9">
                <div
                    class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                            Bahasa
                        </h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                            Tambah Bahasa
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-4 md:p-5">
                        <div class="flex flex-wrap gap-2">
                            <!-- Tag 1 -->
                            <span
                                class="inline-flex items-center gap-x-2 rounded-md border border-gray-300 px-3 py-1 text-sm text-gray-700 dark:text-slate-200">
                                Indonesian: Advanced
                                <button type="button" class="shrink-0 text-gray-500 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>

                            <!-- Tag 2 -->
                            <span
                                class="inline-flex items-center gap-x-2 rounded-md border border-gray-300 px-3 py-1 text-sm text-gray-700 dark:text-slate-200">
                                English: Beginner – Intermediate
                                <button type="button" class="shrink-0 text-gray-500 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Bahasa --}}
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
</div>
