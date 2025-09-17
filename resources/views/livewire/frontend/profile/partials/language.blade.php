    {{-- Bahasa --}}
    <div class="col-span-full md:col-span-full lg:col-span-9">
        <div
            class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none rounded-xl">
            <!-- Header -->
            <div class="flex flex-col rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-3">
                    Bahasa
                </h3>
                <a href="javascript:;" class="text-sm font-medium text-indigo-600 hover:underline"
                    @click="$dispatch('addLanguage')">
                    Tambah Bahasa
                </a>
            </div>

            <!-- Body -->
            <div class="p-4 md:p-5">
                <div class="flex flex-wrap gap-2">
                    @foreach ($this->languages as $language)
                        <span
                            class="inline-flex items-center gap-x-2 rounded-md border border-gray-300 px-3 py-1 text-sm text-gray-700 dark:text-slate-200">
                            {{ $language->language }}: {{ $language->level }}
                            <button type="button" class="shrink-0 text-gray-500 hover:text-red-600"
                                @click="$wire.deleteLanguage('{{ $language->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="latestLanguage"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="latestLanguage-label" wire:ignore wire:ignore.self>
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)] min-h-[calc(100%-56px)] flex items-center">
                <div
                    class="w-full max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div
                        class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 id="latestLanguage-label" class="font-bold text-gray-800 dark:text-white">
                            Bahasa yang dikuasai
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" data-hs-overlay="#latestLanguage">
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
                                <label for="language"
                                    class="block text-sm font-medium mb-2 dark:text-white">Tipe</label>
                                <select wire:model="language"
                                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm
               focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50
               disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700
               dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option value="" selected disabled>Pilih bahasa...</option>

                                    <!-- Bahasa populer -->
                                    <option value="indonesian">Indonesian</option>
                                    <option value="english">English</option>
                                    <option value="arabic">Arabic</option>
                                    <option value="chinese">Chinese (Mandarin)</option>
                                    <option value="japanese">Japanese</option>
                                    <option value="korean">Korean</option>
                                    <option value="french">French</option>
                                    <option value="german">German</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="portuguese">Portuguese</option>
                                    <option value="russian">Russian</option>
                                    <option value="hindi">Hindi</option>
                                    <option value="bengali">Bengali</option>
                                    <option value="urdu">Urdu</option>
                                    <option value="turkish">Turkish</option>
                                    <option value="thai">Thai</option>
                                    <option value="vietnamese">Vietnamese</option>
                                    <option value="malay">Malay</option>
                                    <option value="italian">Italian</option>
                                    <option value="dutch">Dutch</option>
                                    <option value="swedish">Swedish</option>
                                    <option value="norwegian">Norwegian</option>
                                    <option value="finnish">Finnish</option>
                                    <option value="danish">Danish</option>
                                    <option value="greek">Greek</option>
                                    <option value="hebrew">Hebrew</option>
                                    <option value="polish">Polish</option>
                                    <option value="czech">Czech</option>
                                    <option value="hungarian">Hungarian</option>
                                    <option value="romanian">Romanian</option>
                                    <option value="ukrainian">Ukrainian</option>
                                    <option value="persian">Persian (Farsi)</option>
                                    <option value="swahili">Swahili</option>
                                    <option value="filipino">Filipino (Tagalog)</option>
                                    <option value="burmese">Burmese</option>
                                    <option value="lao">Lao</option>
                                    <option value="khmer">Khmer</option>
                                    <option value="nepali">Nepali</option>
                                    <option value="sinhala">Sinhala</option>
                                    <option value="tamil">Tamil</option>
                                    <option value="telugu">Telugu</option>
                                    <option value="marathi">Marathi</option>
                                    <option value="gujarati">Gujarati</option>
                                    <option value="punjabi">Punjabi</option>
                                    <option value="serbian">Serbian</option>
                                    <option value="croatian">Croatian</option>
                                    <option value="slovak">Slovak</option>
                                    <option value="slovenian">Slovenian</option>
                                    <option value="bulgarian">Bulgarian</option>
                                    <option value="estonian">Estonian</option>
                                    <option value="latvian">Latvian</option>
                                    <option value="lithuanian">Lithuanian</option>
                                    <option value="icelandic">Icelandic</option>
                                    <option value="mongolian">Mongolian</option>
                                    <option value="kazakh">Kazakh</option>
                                    <option value="uzbek">Uzbek</option>
                                    <option value="georgian">Georgian</option>
                                    <option value="armenian">Armenian</option>
                                    <option value="albanian">Albanian</option>
                                    <option value="bosnian">Bosnian</option>
                                    <option value="haitian">Haitian Creole</option>
                                    <option value="maori">Maori</option>
                                    <option value="samoan">Samoan</option>
                                    <option value="tongan">Tongan</option>
                                    <option value="zulu">Zulu</option>
                                    <option value="xhosa">Xhosa</option>
                                    <option value="afrikaans">Afrikaans</option>
                                </select>
                            </div>


                            <div class="max-w-full">
                                <label for="level"
                                    class="block text-sm font-medium mb-2 dark:text-white">Kecakapan</label>
                                <select wire:model="level"
                                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm
               focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50
               disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700
               dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option value="" selected disabled>Pilih bahasa...</option>

                                    <!-- Bahasa populer -->
                                    <option value="pemula">Pemulah</option>
                                    <option value="menengah">Menengah</option>
                                    <option value="mahir">Mahir</option>
                                    <option value="fasih">Fasih</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-overlay="#latestLanguage">
                            Close
                        </button>
                        <button type="button" @click="$wire.updateLanguage"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>


        @script
            <script>
                const modal = document.getElementById('latestLanguage')

                document.addEventListener('addLanguage', (e) => {
                    HSOverlay.open('#latestLanguage');
                })

                document.addEventListener('closeModal', () => {
                    HSOverlay.close('#latestLanguage')
                })

                modal.addEventListener('close.hs.overlay', () => {
                    $wire.resetProperty()
                })
            </script>
        @endscript

    </div>
    {{-- Bahasa --}}
