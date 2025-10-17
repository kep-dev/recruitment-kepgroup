<x-layouts.app title="Profil Saya">
    <!-- ========== MAIN CONTENT ========== -->
    <main class="w-full max-w-7xl md:pt-0 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div style="height: max-content"
                class="row-span-3 col-span-12 md:col-span-12 lg:col-span-3 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <div class="p-2 flex items-center border-b border-gray-200 rounded-t-xl dark:border-neutral-700">
                    <img class="inline-block rounded-full" style="width:50px; height:50px; object-fit:cover"
                        src="{{ Auth::user()->applicant->photo }}" alt="Avatar">
                    <h4 class="mx-4 text-md text-gray-800 dark:text-slate-100">
                        {{ Auth::user()->name }}
                    </h4>
                </div>
                <nav
                    class="mt-2 h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <div class=" pb-0 px-2  w-full flex flex-col flex-wrap">
                        <ul class="space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 dark:text-slate-100 rounded-lg hover:bg-neutral-100 focus:outline-hidden focus:bg-gray-100 gray:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 @if (Route::currentRouteName() == 'frontend.profile') bg-neutral-100 dark:bg-neutral-700 @endif"
                                    href="{{ route('frontend.profile') }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                                        <path d="M18 20a6 6 0 0 0-12 0" />
                                        <circle cx="12" cy="10" r="4" />
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>
                                    Profile Saya
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 dark:text-slate-100 rounded-lg hover:bg-neutral-100 focus:outline-hidden focus:bg-gray-100 gray:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 @if (Route::currentRouteName() == 'frontend.profile.application') bg-neutral-100 dark:bg-neutral-700 @endif"
                                    href="{{ route('frontend.profile.application') }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-send-icon lucide-send">
                                        <path
                                            d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                        <path d="m21.854 2.147-10.94 10.939" />
                                    </svg>
                                    Lamaran Saya
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 dark:text-slate-100 rounded-lg hover:bg-neutral-100 focus:outline-hidden focus:bg-gray-100 gray:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 @if (Route::currentRouteName() == 'frontend.profile.saved-job') bg-neutral-100 dark:bg-neutral-700 @endif"
                                    href="{{ route('frontend.profile.saved-job') }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-book-marked-icon lucide-book-marked">
                                        <path d="M10 2v8l3-3 3 3V2" />
                                        <path
                                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                                    </svg>
                                    Lowongan tersimpan
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 dark:text-slate-100 rounded-lg hover:bg-neutral-100 focus:outline-hidden focus:bg-gray-100 gray:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 @if (Route::currentRouteName() == 'frontend.profile.test') bg-neutral-100 dark:bg-neutral-700 @endif"
                                    href="{{ route('frontend.profile.test') }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-notebook-text-icon lucide-notebook-text">
                                        <path d="M2 6h4" />
                                        <path d="M2 10h4" />
                                        <path d="M2 14h4" />
                                        <path d="M2 18h4" />
                                        <rect width="16" height="20" x="4" y="2" rx="2" />
                                        <path d="M9.5 8h5" />
                                        <path d="M9.5 12H16" />
                                        <path d="M9.5 16H14" />
                                    </svg>
                                    Test Saya
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            {{ $slot }}

        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

</x-layouts.app>
