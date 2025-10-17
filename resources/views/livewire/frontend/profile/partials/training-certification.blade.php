{{-- Pelatihan & Sertifikasi --}}
<div class="col-span-full md:col-span-full lg:col-span-9">
    <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
        <!-- Header -->
        <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
            <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                Pelatihan & Sertifikasi
            </h3>
            <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                @click="$dispatch('addTrainingCertification')">
                Tambah Pelatihan & Sertifikasi
            </a>
        </div>

        <!-- Body -->
        @foreach ($this->trainingCertifications as $trainingCertification)
            <div class="p-4 md:p-5 space-y-2">
                <div class="flex items-start justify-between gap-4">
                    <!-- Left Content -->
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <p class="font-semibold text-gray-800 dark:text-slate-200">
                                {{ $trainingCertification->training_certification_title }}
                            </p>
                            <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                {{ $trainingCertification->start_date }} – {{ $trainingCertification->end_date }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-slate-400">
                            {{ $trainingCertification->institution_name }}
                        </p>
                    </div>

                    <!-- Right Action Buttons -->
                    <div class="flex items-center gap-3 shrink-0">
                        <!-- Edit -->
                        <button class="text-indigo-600 hover:text-indigo-800" title="Edit"
                            @click="$dispatch('updateTrainingCertification', {id: '{{ $trainingCertification->id }}'})">
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
                            @click="$dispatch('delete-training-certification', {id: '{{ $trainingCertification->id }}'})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Description -->
                <p class="mt-2 text-[15px] leading-relaxed text-gray-700 dark:text-slate-300">
                    {{ $trainingCertification->description }}
                </p>
            </div>
        @endforeach

    </div>

    <div id="latestTrainingCertification"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="latestTrainingCertification-label" wire:ignore wire:ignore.self>
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
            <div
                class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div
                    class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 id="latestTrainingCertification-label" class="font-bold text-gray-800 dark:text-white">
                        Pelatihan dan Sertifikasi
                    </h3>
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#latestTrainingCertification">
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
                            <label for="training_certification_title"
                                class="block text-sm font-medium mb-2 dark:text-white">Judul Pelatihan atau
                                Sertifikasi</label>
                            <input wire:model='training_certification_title' type="text"
                                id="training_certification_title" placeholder="Cont. Copywriting, Desain Grafis, dll"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="institution_name" class="block text-sm font-medium mb-2 dark:text-white">Nama
                                Penyelenggara</label>
                            <input wire:model='institution_name' type="text" id="institution_name"
                                placeholder="Cont. PT. XYZ, PT. ABC, dll"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <div class="max-w-full">
                            <label for="type" class="block text-sm font-medium mb-2 dark:text-white">Tipe</label>
                            <select wire:model='type'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option selected="">Open this select menu</option>
                                <option value="training">Pelatihan</option>
                                <option value="certification">Sertifikasi</option>
                            </select>
                        </div>

                        <div class="max-w-full">
                            <label for="location" class="block text-sm font-medium mb-2 dark:text-white">Lokasi</label>
                            <select wire:model='location'
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option selected="">Open this select menu</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
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
                            <label for="description"
                                class="block text-sm font-medium mb-2 dark:text-white">Deskripsi</label>
                            <textarea wire:model='description' id="description"
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
                        data-hs-overlay="#latestTrainingCertification">
                        Close
                    </button>
                    <button type="button" @click="$wire.updateTrainingCertification" wire:loading.attr="disabled"
                        wire:target="updateTrainingCertification"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <!-- Teks normal -->
                        <span wire:loading.remove wire:target="updateTrainingCertification">
                            Save changes
                        </span>

                        <!-- Teks saat loading -->
                        <span wire:loading wire:target="updateTrainingCertification" class="flex items-center gap-2">
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

    <x-molecules.alerts.confirm-delete title="Hapus Pelatihan dan Sertifikasi"
        message="Anda yakin ingin menghapus pendidikan terakhir ?" modalId="deleteTrainingCertification"
        :action="'$wire.deleteTrainingCertification'" />


    @script
        <script>
            const modal = document.getElementById('latestTrainingCertification')
            const deleteModal = document.getElementById('deleteTrainingCertification')

            document.addEventListener('addTrainingCertification', (e) => {
                HSOverlay.open('#latestTrainingCertification');
            })
            document.addEventListener('updateTrainingCertification', (e) => {
                HSOverlay.open('#latestTrainingCertification');
            })
            document.addEventListener('closeModal', () => {
                HSOverlay.close('#latestTrainingCertification')
                HSOverlay.close('#deleteTrainingCertification')
            })

            document.addEventListener('delete-training-certification', (e) => {
                $wire.$set('trainingCertificationId', e.detail.id)
                HSOverlay.open('#deleteTrainingCertification');
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
{{-- Pelatihan & Sertifikasi --}}
