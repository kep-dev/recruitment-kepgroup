{{-- Pendidikan Terakhir --}}
<div class="col-span-full md:col-span-full lg:col-span-9">
    <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
        <!-- Header -->
        <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
            <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                Pendidikan Terakhir
            </h3>

            <a href="javascript:;" @click="$dispatch('addEducation')"
                class="text-sm font-medium text-indigo-600 hover:underline">
                Tambah Pendidikan Terakhir
            </a>
        </div>

        @foreach ($this->educations as $education)
            <div class="p-4 md:p-5 space-y-2">
                <div class="flex items-start justify-between gap-4">
                    <!-- Left Content -->
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <p class="font-semibold text-gray-800 dark:text-slate-200">
                                {{ $education->university }}
                            </p>
                            <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                {{ $education->graduation_year }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-slate-400">
                            {{ $education->major }}, {{ $education->education_level }}, GPA: {{ $education->gpa }}
                        </p>
                    </div>

                    <!-- Right Action Buttons -->
                    <div class="flex items-center gap-3 shrink-0">
                        <!-- Edit -->
                        <button class="text-indigo-600 hover:text-indigo-800" title="Edit"
                            @click="$dispatch('updateEducation', {id: '{{ $education->id }}'})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                <path d="m15 5 4 4" />
                            </svg>
                        </button>

                        <!-- Delete -->
                        <button class="text-red-600 hover:text-red-800" title="Delete"
                            @click="$dispatch('delete-education', {id: '{{ $education->id }}'})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
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
        @endforeach
    </div>

    <div id="latestEducationModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="latestEducationModal-label" @close.window="$wire.rererer()"
        wire:ignore wire:ignore.self>
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
            <div
                class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div
                    class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 id="latestEducationModal-label" class="font-bold text-gray-800 dark:text-white">
                        Pendidikan Terakhir
                    </h3>
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#latestEducationModal">
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
                        <div class="max-w-full">
                            <label for="education_level" class="block text-sm font-medium mb-2 dark:text-white">Jenjang
                                Pendidikan</label>
                            <select wire:model='education_level'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option selected="">Open this select menu</option>
                                <option value="S3" @selected($education_level == 'S3')>S3</option>
                                <option value="S2" @selected($education_level == 'S2')>S2</option>
                                <option value="S1" @selected($education_level == 'S1')>S1</option>
                                <option value="D4" @selected($education_level == 'D4')>D4</option>
                                <option value="D3" @selected($education_level == 'D3')>D3</option>
                                <option value="D2" @selected($education_level == 'D2')>D2</option>
                                <option value="D1" @selected($education_level == 'D1')>D1</option>
                                <option value="SMA/Sederajat" @selected($education_level == 'SMA/Sederajat')>SMA/Sederajat</option>
                                <option value="SMP/Sederajat" @selected($education_level == 'SMP/Sederajat')>SMP/Sederajat</option>
                                <option value="SD/Sederajat" @selected($education_level == 'SD/Sederajat')>SD/Sederajat</option>
                            </select>
                        </div>

                        <div class="max-w-full">
                            <label for="location" class="block text-sm font-medium mb-2 dark:text-white">Lokasi</label>
                            <input wire:model='location' type="text" id="location"
                                placeholder="Cont. Malang, Indonesia"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="university"
                                class="block text-sm font-medium mb-2 dark:text-white">Universitas</label>
                            <input wire:model='university' type="text" id="university"
                                placeholder="Cont. Universitas Indonesia, Universitas Airlangga, dll"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="major"
                                class="block text-sm font-medium mb-2 dark:text-white">Jurusan</label>
                            <input wire:model='major' type="text" id="major"
                                placeholder="Cont. Teknik Informatika, Teknik Mesin, dll"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="certificate_number"
                                class="block text-sm font-medium mb-2 dark:text-white">Nomor Ijazah</label>
                            <input wire:model='certificate_number' type="text" id="certificate_number"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="main_number"
                                class="block text-sm font-medium mb-2 dark:text-white">NIS/NIM</label>
                            <input wire:model='main_number' type="text" id="main_number"
                                placeholder="Nomor Induk Siswa/Nomor Induk Mahasiswa"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="graduation_year" class="block text-sm font-medium mb-2 dark:text-white">Tahun
                                Kelulusan</label>
                            <input wire:model='graduation_year' type="number" id="graduation_year" min="1900"
                                max="2099" step="1"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="YYYY">
                        </div>

                        <div class="max-w-full">
                            <label for="gpa" class="block text-sm font-medium mb-2 dark:text-white">IPK/Nilai
                                Akhir</label>
                            <input wire:model='gpa' type="number" id="gpa"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                    </div>
                </div>
                <div
                    class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                        data-hs-overlay="#latestEducationModal">
                        Close
                    </button>
                    <button type="button" @click="$wire.updateEducation" wire:loading.attr="disabled"
                        wire:target="updateEducation"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <!-- Teks normal -->
                        <span wire:loading.remove wire:target="updateEducation">
                            Save changes
                        </span>

                        <!-- Teks saat loading -->
                        <span wire:loading wire:target="updateEducation" class="flex items-center gap-2">
                            {{-- <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg> --}}
                            Loading...
                        </span>
                    </button>

                </div>
            </div>
        </div>
    </div>

    <x-molecules.alerts.confirm-delete title="Hapus Pendidikan Terakhir"
        message="Anda yakin ingin menghapus pendidikan terakhir ?" modalId="deleteEducation" :action="'$wire.deleteEducation'" />


    @script
        <script>
            const modal = document.getElementById('latestEducationModal')
            const deleteModal = document.getElementById('deleteEducation')

            document.addEventListener('addEducation', (e) => {
                HSOverlay.open('#latestEducationModal');
            })
            document.addEventListener('updateEducation', (e) => {
                HSOverlay.open('#latestEducationModal');
            })
            document.addEventListener('closeModal', () => {
                HSOverlay.close('#latestEducationModal')
                HSOverlay.close('#deleteEducation')
            })

            document.addEventListener('delete-education', (e) => {
                $wire.$set('educationId', e.detail.id)
                HSOverlay.open('#deleteEducation');
            })

            modal.addEventListener('close.hs.overlay', () => {
                $wire.resetProperty()
            })

            deleteModal.addEventListener('close.hs.overlay', () => {
                $wire.resetProperty()
            })
        </script>
    @endscript

</div>
{{-- Pendidikan Terakhir --}}
