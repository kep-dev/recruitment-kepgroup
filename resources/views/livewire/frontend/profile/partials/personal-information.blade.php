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
            <img src="{{ $user->applicant->photo }}" alt="Avatar" class="rounded-full"
                style="width:100px; height:100px; object-fit:cover" />

            <!-- Grid informasi -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-6">
                <!-- Name -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Nama</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->name }}</p>
                </div>

                <!-- NIK -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Nomor Induk Kependudukan</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->nik }}</p>
                </div>

                <!-- Gender -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Jenis Kelamin</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">
                        {{ $user->applicant->gender = 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>

                <!-- Date of Birth -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Tempat Lahir</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->place_of_birth ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Tanggal Lahir</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->date_of_birth }}</p>
                </div>



                <!-- Email -->
                <div>
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

                <!-- Phone -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Nomer Handphone</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->phone_number }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Kode Pos</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->postal_code }}</p>
                </div>

                <!-- Location -->
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Alamat</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200 capitalize">
                        {{ $user->applicant?->province?->name .
                            ', ' .
                            $user->applicant?->district?->name .
                            ', ' .
                            $user->applicant?->regency?->name .
                            ', ' .
                            $user->applicant?->village?->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-300">Detail Alamat</p>
                    <p class="mt-1 text-gray-700 dark:text-slate-200">{{ $user->applicant->address_line }}</p>
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
        @close.window="$wire.rererer()" wire:ignore.self>

        <!-- wrapper: vertically centered -->
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto min-h-[calc(100%-56px)] flex items-center">
            <div
                class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">

                <!-- HEADER -->
                <div
                    class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 id="hs-vertically-centered-scrollable-modal-label"
                        class="font-bold text-gray-800 dark:text-white">
                        Informasi Pribadi
                    </h3>
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
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

                <!-- BODY -->
                <div class="p-4 overflow-y-auto">
                    <div x-data="{
                        preview: null,
                        defaultUrl: @js($user->applicant->photo ?? asset('images/avatar-placeholder.png')),
                        pick() { $refs.file.click() },
                        change(e) {
                            const f = e.target.files[0];
                            if (!f) return;
                            if (!['image/jpeg', 'image/png', 'image/webp'].includes(f.type) || f.size > 2 * 1024 * 1024) {
                                alert('Hanya JPEG/PNG/WEBP, maks. 2MB');
                                e.target.value = '';
                                return;
                            }
                            this.preview = URL.createObjectURL(f);
                        }
                    }" class="flex items-start gap-5 mb-6">
                        <div
                            class="relative w-32 h-32 rounded-full overflow-hidden ring-2 ring-gray-200 dark:ring-neutral-700 flex-none">
                            <div class="absolute inset-0 bg-gray-100 dark:bg-neutral-700"></div>
                            <img class="absolute inset-0 w-full h-full object-cover" :src="preview || defaultUrl"
                                alt="Profile Photo" width="128" height="128" loading="lazy"
                                @load="$el.previousElementSibling.style.display='none'">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-neutral-200 mb-2">
                                Profile Picture
                            </label>
                            <button type="button" @click="pick"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 shadow-2xs dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
                                Upload Photo
                            </button>
                            <span class="ml-2 text-sm text-gray-500 dark:text-neutral-400" wire:loading
                                wire:target="photo">
                                Mengunggah…
                            </span>
                            <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">JPEG/PNG/WEBP, maks. 2 MB.</p>
                            <input x-ref="file" type="file" class="hidden" accept="image/*" @change="change"
                                wire:model="photo">
                            @error('photo')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- FORM FIELD -->
                    <div class="space-y-4">
                        <div>
                            <label for="nik" class="block text-sm font-medium mb-2 dark:text-white">Nomer Induk
                                Kependudukan</label>
                            <input wire:model='nik' type="number" id="nik" minlength="16"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        </div>
                        <div>
                            <label for="phone_number" class="block text-sm font-medium mb-2 dark:text-white">Nomor
                                Handphone</label>
                            <input wire:model='phone_number' type="number" id="phone_number"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        </div>
                        <div>
                            <label for="place_of_birth" class="block text-sm font-medium mb-2 dark:text-white">Tempat
                                Lahir</label>
                            <input wire:model='place_of_birth' type="text" id="place_of_birth"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium mb-2 dark:text-white">Tanggal
                                Lahir</label>
                            <input wire:model='date_of_birth' type="date" id="date_of_birth"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium mb-2 dark:text-white">Jenis
                                Kelamin</label>
                            <select wire:model='gender'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option selected="">Open this select menu</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="provinceId"
                                class="block text-sm font-medium mb-2 dark:text-white">Provinsi</label>
                            <select wire:model.change='provinceId'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option selected="">Open this select menu</option>
                                @foreach ($provinces as $key => $value)
                                    <option value="{{ $key }}" @selected($provinceId == $key)>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="regencyId"
                                class="block text-sm font-medium mb-2 dark:text-white">Kabupaten</label>
                            <select wire:model.change='regencyId'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option selected="">Open this select menu</option>
                                @foreach ($this->regencies as $key => $value)
                                    <option value="{{ $key }}" @selected($regencyId == $key)>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="districtId"
                                class="block text-sm font-medium mb-2 dark:text-white">Kecamatan</label>
                            <select wire:model.change='districtId'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option selected="">Open this select menu</option>
                                @foreach ($this->districts as $key => $value)
                                    <option value="{{ $key }}" @selected($districtId == $key)>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="village_code"
                                class="block text-sm font-medium mb-2 dark:text-white">Desa</label>
                            <select wire:model.change='village_code'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option selected="">Open this select menu</option>
                                @foreach ($this->villages as $key => $value)
                                    <option value="{{ $key }}" @selected($village_code == $key)>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="postal_code" class="block text-sm font-medium mb-2 dark:text-white">Kode
                                Pos</label>
                            <input wire:model='postal_code' type="number" id="postal_code" minlength="16"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        </div>
                        <div>
                            <label for="textarea-label" class="block text-sm font-medium mb-2 dark:text-white">Alamat
                                Lengkap</label>
                            <textarea id="textarea-label" wire:model='address_line'
                                class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                rows="3" placeholder="RT/RW, ..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div
                    class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700"
                        data-hs-overlay="#hs-vertically-centered-scrollable-modal">
                        Close
                    </button>
                    <button type="button" @click="$wire.updateApplicant" wire:loading.attr="disabled"
                        wire:target="updateApplicant"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50">
                        <span wire:loading.remove wire:target="updateApplicant">Save changes</span>
                        <span wire:loading wire:target="updateApplicant">Loading...</span>
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
