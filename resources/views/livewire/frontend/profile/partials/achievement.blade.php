    {{-- Prestasi --}}
    <div class="col-span-full md:col-span-full lg:col-span-9">
        <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
            <!-- Header -->
            <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                    Prestasi
                </h3>
                <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                    @click="$dispatch('addAchievement')">
                    Tambah Prestasi
                </a>
            </div>

            @foreach ($this->achievements as $achievement)
                <div class="p-4 md:p-5 space-y-2">
                    <div class="flex items-start justify-between gap-4">
                        <!-- Left Content -->
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <p class="font-semibold text-gray-800 dark:text-slate-200">
                                    {{ $achievement->achievement_name }}
                                </p>
                                <span class="px-2 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                    {{ $achievement->year }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">
                                {{ $achievement->organization_name }}
                            </p>
                        </div>

                        <!-- Right Action Buttons -->
                        <div class="flex items-center gap-3 shrink-0">
                            <!-- Edit -->
                            <button class="text-indigo-600 hover:text-indigo-800" title="Edit"
                                @click="$dispatch('updateAchievement', {id: '{{ $achievement->id }}'})">
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
                                @click="$dispatch('delete-achievement', {id: '{{ $achievement->id }}'})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="latestAchievement"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="latestAchievement-label" wire:ignore wire:ignore.self>
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
                <div
                    class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div
                        class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="latestAchievement-label" class="font-bold text-gray-800 dark:text-white">
                            Prestasi
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" data-hs-overlay="#latestAchievement">
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
                                <label for="achievement_name"
                                    class="block text-sm font-medium mb-2 dark:text-white">Nama Prestasi</label>
                                <input wire:model='achievement_name' type="text" id="achievement_name"
                                    placeholder="Cont. Juara 1 Hackaton, dll"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <div class="max-w-full">
                                <label for="organization_name"
                                    class="block text-sm font-medium mb-2 dark:text-white">Nama
                                    Organisasi</label>
                                <input wire:model='organization_name' type="text" id="organization_name"
                                    placeholder="Cont. Komdigi, dll"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <div class="max-w-full">
                                <label for="year" class="block text-sm font-medium mb-2 dark:text-white">Tahun
                                </label>
                                <input wire:model='year' type="number" id="year" min="1900" max="2099"
                                    step="1"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="YYYY">
                            </div>

                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-overlay="#latestAchievement">
                            Close
                        </button>
                        <button type="button" @click="$wire.updateAchievement"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <x-molecules.alerts.confirm-delete title="Hapus Prestasi" message="Anda yakin ingin menghapus prestasi ?"
            modalId="deleteAchievement" :action="'$wire.deleteAchievement'" />

        @script
            <script>
                const modal = document.getElementById('latestAchievement')
                const deleteModal = document.getElementById('deleteAchievement')

                document.addEventListener('addAchievement', (e) => {
                    HSOverlay.open('#latestAchievement');
                })
                document.addEventListener('updateAchievement', (e) => {
                    HSOverlay.open('#latestAchievement');
                })
                document.addEventListener('closeModal', () => {
                    HSOverlay.close('#latestAchievement')
                    HSOverlay.close('#deleteAchievement')
                })

                document.addEventListener('delete-achievement', (e) => {
                    $wire.$set('achievementId', e.detail.id)
                    HSOverlay.open('#deleteAchievement');
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
    {{-- Prestasi --}}
