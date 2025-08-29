    {{-- Pengalaman Kerja --}}
    <div class="col-span-full md:col-span-full lg:col-span-9" x-data="{ id: null }">
        <div
            class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
            <!-- Header -->
            <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">Pengalaman Kerja</h3>
                <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                    @click="$dispatch('addWorkExperience')">
                    Tambah Pengalaman Kerja
                </a>
            </div>

            @foreach ($this->workExperiences as $workExperience)
                <div class="p-4 md:p-5">
                    <div class="space-y-6">
                        <div>
                            <div class="flex items-start justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-3">
                                        <p class="font-semibold text-gray-800 dark:text-slate-200">
                                            {{ $workExperience->job_title }}
                                        </p>
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                                            {{ $workExperience->start_date }} –
                                            {{ $workExperience->end_date ?? 'Sekarang' }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 dark:text-slate-400">
                                        {{ $workExperience->company_name }}
                                        <span class="mx-1">·</span> {{ $workExperience->job_position }}
                                        <span class="mx-1">·</span> {{ $workExperience->industry }}
                                    </p>
                                </div>

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
                                    <button class="text-red-600 hover:text-red-800" title="Delete"
                                        @click="$dispatch('delete-work-experience', {id: '{{ $workExperience->id }}'})">
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

                            <p class="mt-2 text-[15px] leading-relaxed text-gray-700 dark:text-slate-300">
                                {{ $workExperience->description }}
                            </p>

                            <!-- Divider -->
                            <div class="my-4 border-t border-gray-200 dark:border-white/10"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="latestWorkExperienceModal"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="latestWorkExperienceModal-label" wire:ignore
            wire:ignore.self>
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
                <div
                    class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div
                        class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="latestWorkExperienceModal-label" class="font-bold text-gray-800 dark:text-white">
                            Pengalaman Kerja
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" data-hs-overlay="#latestWorkExperienceModal">
                            <span class="sr-only">Close</span>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 overflow-y-auto">
                        <div class="space-y-4">

                            <div class="max-w-full">
                                <label for="job_title" class="block text-sm font-medium mb-2 dark:text-white">Nama
                                    Pekerjaan</label>
                                <input wire:model='job_title' type="text" id="job_title"
                                    placeholder="Cont. Programmer, Designer, dll"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <div class="max-w-full">
                                <label for="company_name" class="block text-sm font-medium mb-2 dark:text-white">Nama
                                    Perusahaan</label>
                                <input wire:model='company_name' type="text" id="company_name"
                                    placeholder="Cont. PT. XYZ, PT. ABC, dll"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <div class="max-w-full">
                                <label for="job_position"
                                    class="block text-sm font-medium mb-2 dark:text-white">Posisi</label>
                                <input wire:model='job_position' type="text" id="job_position"
                                    placeholder="Cont. Manager, Designer, dll"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <div class="max-w-full">
                                <label for="industry" class="block text-sm font-medium mb-2 dark:text-white">Bergerak
                                    Di Bidang</label>
                                <input wire:model='industry' type="text" id="industry"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <div class="w-full flex flex-col lg:flex-row gap-4">
                                <div class="w-full lg:w-1/2">
                                    <label for="start_date"
                                        class="block text-sm font-medium mb-2 dark:text-white">Dari</label>
                                    <input wire:model='start_date' type="date" id="start_date"
                                        class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                </div>
                                <div class="w-full lg:w-1/2">
                                    <label for="end_date"
                                        class="block text-sm font-medium mb-2 dark:text-white">Sampai</label>
                                    <input wire:model='end_date' type="date" id="end_date"
                                        class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                </div>
                            </div>

                            <div class="w-full">
                                <div class="flex">
                                    <input type="checkbox"
                                        class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                        id="hs-checked-checkbox" wire:model='currently_working'>
                                    <label for="hs-checked-checkbox"
                                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Masih Bekerja</label>
                                </div>
                            </div>

                            <div class="w-full">
                                <label for="description"
                                    class="block text-sm font-medium mb-2 dark:text-white">Deskripsi</label>
                                <textarea
                                    wire:model='description' id="description"
                                    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    rows="3" placeholder="This is a textarea placeholder"></textarea>
                            </div>

                            {{-- <div class="max-w-full">
                                <label for="gpa" class="block text-sm font-medium mb-2 dark:text-white">IPK/Nilai
                                    Akhir</label>
                                <input wire:model='gpa' type="number" id="gpa"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div> --}}
                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-overlay="#latestWorkExperienceModal">
                            Close
                        </button>
                        <button type="button" @click="$wire.updateWorkExperience"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <x-molecules.alerts.confirm-delete title="Hapus Pendidikan Terakhir"
            message="Anda yakin ingin menghapus pendidikan terakhir ?" modalId="deleteWorkExperience"
            :action="'$wire.deleteWorkExperience'" />


        @script
            <script>
                const modal = document.getElementById('latestWorkExperienceModal')
                const deleteModal = document.getElementById('deleteWorkExperience')

                document.addEventListener('addWorkExperience', (e) => {
                    HSOverlay.open('#latestWorkExperienceModal');
                })
                document.addEventListener('updateWorkExperience', (e) => {
                    HSOverlay.open('#latestWorkExperienceModal');
                })
                document.addEventListener('closeModal', () => {
                    HSOverlay.close('#latestWorkExperienceModal')
                    HSOverlay.close('#deleteWorkExperience')
                })

                document.addEventListener('delete-work-experience', (e) => {
                    $wire.$set('workExperienceId', e.detail.id)
                    HSOverlay.open('#deleteWorkExperience');
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
    {{-- Pengalaman Kerja --}}
