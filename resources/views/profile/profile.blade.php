<x-layouts.app>

    {{-- <head>
        <!-- Title -->
        <title>Profile</title>
    </head> --}}

    <!-- ========== MAIN CONTENT ========== -->
    <main class="w-full max-w-7xl md:pt-0 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-9 gap-4">
            @include('profile.side-profile')
            <div
                class="col-start-4 col-span-9 bg-white border border-white-200 shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <strong>
                    <h2 class="text-3xl dark:text-black">My Profile</h2>
                </strong>
            </div>
            <div
                class="col-start-4 col-span-9 bg-white border border-white-200 shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <h4 class="text-lg font-bold text-gray-800 dark:text-black">Availability</h4>
                <div class="flex justify-between">
                    <span class="justify-start">I am open for job opportunities</span>
                    <label for="hs-basic-usage" class="relative inline-block w-11 h-6 cursor-pointer justify-end">
                        <input type="checkbox" id="hs-basic-usage" class="peer sr-only">
                        <span
                            class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                        <span
                            class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                    </label>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Personal Information
                        </h3>

                        <div class="flex items-center gap-x-1">
                            <div class="hs-tooltip inline-block">
                                <button type="button"
                                    class="hs-tooltip-toggle size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye-icon lucide-eye">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <span
                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs"
                                        role="tooltip">
                                        Tampilkan Data
                                    </span>
                                </button>
                            </div>
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
                        <img class="inline-block rounded-full" style="width:100px; height:100px; object-fit:cover" src="{{ asset('images/include/powerplants.jpg') }}" alt="Avatar">
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Personal Information --}}

            {{-- Professional Headline --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
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

            {{-- Latest Education --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Latest Education
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Latest Education --}}

            {{-- Years of Full-time Work Experience --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
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

            {{-- Work Experience --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Work Experience
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Work Experience --}}

            {{-- Organizational Experience --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Organizational Experience
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Organizational Experience --}}

            {{-- Training or Certification --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Training or Certification
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Training or Certification --}}

            {{-- Achievement --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Achievement
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Achievement --}}

            {{-- Language --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div
                        class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Language
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-gray-500">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Language --}}

        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

</x-layouts.app>
