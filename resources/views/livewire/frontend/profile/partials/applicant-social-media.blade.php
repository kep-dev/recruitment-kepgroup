    {{-- Bahasa --}}
    <div class="col-span-full md:col-span-full lg:col-span-9">
        <div class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
            <!-- Header -->
            <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                    Media Sosial
                </h3>
                <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                    @click="$dispatch('addSocialMedia')">
                    Tambah Media Sosial
                </a>
            </div>

            <!-- Body -->
            <div class="p-4 md:p-5">
                <div class="flex flex-wrap gap-2">
                    @foreach ($this->socialMedias as $socialMedia)
                        <a href="{{ $socialMedia->url }}">
                            <span
                                class="inline-flex items-center gap-x-2 rounded-md border border-gray-300 px-3 py-1 text-sm text-gray-700 dark:text-slate-200">
                                {{ $socialMedia->name }}
                                <button type="button" class="shrink-0 text-gray-500 hover:text-red-600"
                                    @click="$wire.deleteSocialMedia('{{ $socialMedia->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="latestSocialMedia"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="latestSocialMedia-label" wire:ignore wire:ignore.self>
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
                <div
                    class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div
                        class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="latestSocialMedia-label" class="font-bold text-gray-800 dark:text-white">
                            Media Sosial
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" data-hs-overlay="#latestSocialMedia">
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
                                <label for="name" class="block text-sm font-medium mb-2 dark:text-white">Sosial
                                    Media</label>
                                <select wire:model='name'
                                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option selected="">Pilih Sosial Media</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Twitter/X">Twitter / X</option>
                                    <option value="Telegram">Telegram</option>
                                    <option value="YouTube">YouTube</option>
                                    <option value="GitHub">GitHub</option>
                                    <option value="Dribbble">Dribbble</option>
                                    <option value="Behance">Behance</option>
                                    <option value="Portofolio">Portofolio</option>
                                </select>
                            </div>
                            <div class="max-w-full">
                                <label for="url" class="block text-sm font-medium mb-2 dark:text-white">URL</label>
                                <input wire:model='url' type="text" id="url"
                                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-overlay="#latestSocialMedia">
                            Close
                        </button>
                        <button type="button" @click="$wire.updateSocialMedia" wire:loading.attr="disabled"
                            wire:target="updateSocialMedia"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <!-- Teks normal -->
                            <span wire:loading.remove wire:target="updateSocialMedia">
                                Save changes
                            </span>

                            <!-- Teks saat loading -->
                            <span wire:loading wire:target="updateSocialMedia" class="flex items-center gap-2">
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


        @script
            <script>
                const modal = document.getElementById('latestSocialMedia')

                document.addEventListener('addSocialMedia', (e) => {
                    HSOverlay.open('#latestSocialMedia');
                })

                document.addEventListener('closeModal', () => {
                    HSOverlay.close('#latestSocialMedia')
                })

                modal.addEventListener('close.hs.overlay', () => {
                    $wire.resetProperty()
                })
            </script>
        @endscript

    </div>
    {{-- Bahasa --}}
