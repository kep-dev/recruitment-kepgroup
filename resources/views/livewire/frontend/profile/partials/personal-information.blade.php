{{-- Informasi Pribadi --}}
<div class="col-span-full md:col-span-full lg:col-span-9">
    <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
        <!-- Header -->
        <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
            <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                Informasi Pribadi
            </h3>

            <div class="flex items-center gap-x-3">
                <!-- Eye -->
                <button type="button" class="text-purple-600 hover:text-purple-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path
                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
                <!-- Pencil -->
                <button type="button" class="text-purple-600 hover:text-purple-800"
                    @click="$dispatch('openModal', {'user_id': '{{ $user->id }}'})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
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
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->name }}</p>
                </div>

                <!-- NIK -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">NIK</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->nik }}</p>
                </div>

                <!-- Date of Birth -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Date of Birth</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->date_of_birth }}</p>
                </div>

                <!-- Gender -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Gender</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->gender }}</p>
                </div>

                <!-- Location -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Location</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->city }},
                        {{ $user->applicant->province }}</p>
                </div>

                <!-- Phone -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Phone</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->phone_number }}</p>
                </div>

                <!-- Email -->
                <div class="sm:col-span-2">
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Email</p>
                    <div class="mt-1 inline-flex items-center gap-2">
                        <span class="text-gray-700 dark:text-slate-200">{{ $user->email }}</span>
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-500" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5" />
                        </svg> --}}
                    </div>
                </div>
                <!-- LinkedIn -->
                {{-- <div class="sm:col-span-2">
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Linkedin Profile</p>
                    <a href="#" class="mt-1 inline-flex items-center gap-2 text-indigo-600 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M4.98 3.5A2.5 2.5 0 1 0 5 8.5a2.5 2.5 0 0 0-.02-5ZM4 9h2.9v12H4Zm5.48 0H13v1.64h.04a3.2 3.2 0 0 1 2.88-1.58c3.08 0 3.65 2.03 3.65 4.68V21H16.7v-5.27c0-1.26-.02-2.88-1.76-2.88-1.77 0-2.04 1.38-2.04 2.79V21H9.48Z" />
                        </svg>
                        Muhammad Ridho Prasetyo
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

    <div id="hs-vertically-centered-scrollable-modal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="hs-vertically-centered-scrollable-modal-label"
        @close.window="$wire.rererer()" wire:ignore wire:ignore.self>
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
            <div
                class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div
                    class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 id="hs-vertically-centered-scrollable-modal-label"
                        class="font-bold text-gray-800 dark:text-white">
                        Informasi Pribadi
                    </h3>
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#hs-vertically-centered-scrollable-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <div class="space-y-4">
                        {{-- <div class="max-w-full">
                            <label for="name" class="block text-sm font-medium mb-2 dark:text-white">Nama</label>
                            <input wire:model='name' type="text" id="name"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div> --}}
                        <div class="max-w-full">
                            <label for="nik" class="block text-sm font-medium mb-2 dark:text-white">NIK</label>
                            <input wire:model='nik' type="number" id="nik" minlength="16"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                        <div class="max-w-full">
                            <label for="date_of_birth" class="block text-sm font-medium mb-2 dark:text-white">Tanggal
                                Lahir</label>
                            <input wire:model='date_of_birth' type="date" id="date_of_birth"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                        </div>
                        <div class="max-w-full">
                            <label for="gender" class="block text-sm font-medium mb-2 dark:text-white">Jenis
                                Kelamin</label>
                            <select wire:model='gender'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option selected="">Open this select menu</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="max-w-full">
                            <label for="city" class="block text-sm font-medium mb-2 dark:text-white">Kota</label>
                            <input wire:model='city' type="text" id="city"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                        <div class="max-w-full">
                            <label for="province"
                                class="block text-sm font-medium mb-2 dark:text-white">Provinsi</label>
                            <input wire:model='province' type="text" id="province"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                        <div class="max-w-full">
                            <label for="phone_number" class="block text-sm font-medium mb-2 dark:text-white">Nomor
                                Handphone</label>
                            <input wire:model='phone_number' type="number" id="phone_number"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                    </div>
                </div>
                <div
                    class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                        data-hs-overlay="#hs-vertically-centered-scrollable-modal">
                        Close
                    </button>
                    <button type="button" @click="$wire.updateApplicant"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            document.addEventListener('openModal', (e) => {
                HSOverlay.open('#hs-vertically-centered-scrollable-modal');
            })
            document.addEventListener('closeModal', () => {
                HSOverlay.close('#hs-vertically-centered-scrollable-modal');
            })
            document.getElementById('hs-vertically-centered-scrollable-modal')
                .addEventListener('close.hs.overlay', () => {
                    $wire.resetProperty()
                })
        </script>
    @endscript
</div>
{{-- Informasi Pribadi --}}
