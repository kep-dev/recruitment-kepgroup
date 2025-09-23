    {{-- Bahasa --}}
    <div class="col-span-full md:col-span-full lg:col-span-9">
        <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
            <!-- Header -->
            <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                    Dokumen Pendukung
                </h3>
                <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                    @click="$dispatch('addDocument')">
                    Tambah Dokumen Pendukung
                </a>
            </div>

            <!-- Body -->
            <div class="p-4 md:p-5">
                <div class="flex flex-wrap gap-2">
                    <ul class="w-full flex flex-col">
                        @foreach ($this->documents as $document)
                            <li
                                class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
                                <div class="flex justify-between w-full">
                                    {{ $document->vacancyDocument->name }}
                                    <div>
                                        <a href="">
                                            <span
                                                class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium text-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-arrow-down-to-line-icon lucide-arrow-down-to-line">
                                                    <path d="M12 17V3" />
                                                    <path d="m6 11 6 6 6-6" />
                                                    <path d="M19 21H5" />
                                                </svg>
                                            </span>
                                        </a>
                                        <a href="javascript:;"
                                        @click="$wire.deleteDocument('{{ $document->id }}')"
                                        >
                                            <span
                                                class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium text-red-600">
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
                                            </span>
                                        </a>
                                    </div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div id="latestDocument"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="latestDocument-label" wire:ignore wire:ignore.self>
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
                <div
                    class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div
                        class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="latestDocument-label" class="font-bold text-gray-800 dark:text-white">
                            Dokumen Pendukung
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" data-hs-overlay="#latestDocument">
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
                                <label for="vacancy_document_id"
                                    class="block text-sm font-medium mb-2 dark:text-white">Dokumen</label>
                                <select wire:model='vacancy_document_id'
                                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option selected="">Pilih Dokumen</option>
                                    @forelse ($this->vacancyDocuments as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @empty
                                        <option disabled>Data Tidak Tersedia</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="max-w-full">
                                <label for="file"
                                    class="block text-sm font-medium mb-2 dark:text-white">File</label>
                                <input type="file" name="file-input" id="file-input" wire:model='applicantDocument'
                                    class="block w-full border border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                                        file:bg-gray-50 file:border-0
                                        file:me-4
                                        file:py-3 file:px-4
                                        dark:file:bg-neutral-700 dark:file:text-neutral-400">
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-overlay="#latestDocument">
                            Close
                        </button>
                        <button type="button" @click="$wire.updateDocument"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>


        @script
            <script>
                const modal = document.getElementById('latestDocument')

                document.addEventListener('addDocument', (e) => {
                    HSOverlay.open('#latestDocument');
                })

                document.addEventListener('closeModal', () => {
                    HSOverlay.close('#latestDocument')
                })

                modal.addEventListener('close.hs.overlay', () => {
                    $wire.resetProperty()
                })
            </script>
        @endscript

    </div>
    {{-- Bahasa --}}
