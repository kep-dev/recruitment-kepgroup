    {{-- Bahasa --}}
    <div class="col-span-full md:col-span-full lg:col-span-9">
        <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
            <!-- Header -->
            <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                    Gaji
                </h3>

                <div class="flex items-center gap-x-1">
                    @if ($this->salary)
                        <div class="hs-tooltip inline-block">
                            <button type="button"
                                class="hs-tooltip-toggle size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                @click="$dispatch('updateSalary', {id: '{{ $this->salary->id }}'})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil">
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
                    @endif
                </div>
            </div>

            @if (is_null($this->salary))
                <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                    <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                        @click="$dispatch('addSalary')">
                        Tambah Gaji
                    </a>
                </div>
            @endif

            <!-- Body -->
            <div class="p-4 md:p-5">
                <div class="flex flex-col gap-2">

                    @if ($this->salary)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">Gaji yang diharapkan</p>
                            <p class="mt-1 text-gray-900 dark:text-neutral-100">
                                {{ $this->salary->expected_salary }}<span
                                    class="text-gray-500 dark:text-neutral-400">/Bulan</span>
                            </p>
                        </div>

                        <!-- Divider -->
                        <div class="my-4 h-px bg-gray-200 dark:bg-neutral-800"></div>

                        <!-- Current Salary -->
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">Gaji saat ini</p>
                            <p class="mt-1 text-gray-900 dark:text-neutral-100">
                                {{ $this->salary->current_salary }}<span
                                    class="text-gray-500 dark:text-neutral-400">/Bulan</span>
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div id="latestSalary"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="latestSalary-label" wire:ignore wire:ignore.self>
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
                <div
                    class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div
                        class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="latestSalary-label" class="font-bold text-gray-800 dark:text-white">
                            Gaji
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" data-hs-overlay="#latestSalary">
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
                                <label for="expected_salary" class="block text-sm font-medium mb-2 dark:text-white">Gaji
                                    yang diharapkan</label>
                                <input wire:model='expected_salary' type="number" id="expected_salary"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>
                            <div class="max-w-full">
                                <label for="current_salary" class="block text-sm font-medium mb-2 dark:text-white">Gaji
                                    saat ini</label>
                                <input wire:model='current_salary' type="number" id="current_salary"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-overlay="#latestSalary">
                            Close
                        </button>
                        <button type="button" @click="$wire.updateSalary"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>


        @script
            <script>
                const modal = document.getElementById('latestSalary')

                document.addEventListener('addSalary', (e) => {
                    HSOverlay.open('#latestSalary');
                })
                document.addEventListener('updateSalary', (e) => {
                    HSOverlay.open('#latestSalary');
                })
                document.addEventListener('closeModal', () => {
                    HSOverlay.close('#latestSalary')
                })

                modal.addEventListener('close.hs.overlay', () => {
                    $wire.resetProperty()
                })
            </script>
        @endscript

    </div>
    {{-- Bahasa --}}
