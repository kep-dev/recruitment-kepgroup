<x-layouts.app>

    <main class="w-full max-w-7xl md:pt-0 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-9 gap-4">
            @include('profile.side-profile')
            <div
                class="col-start-4 col-span-9 bg-white border border-white-200 shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <strong>
                    <h2 class="text-3xl dark:text-black">My Application</h2>
                </strong>
            </div>

            {{-- Availability --}}
            <div
                class="col-start-4 col-span-9 bg-white border border-white-200 shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <h4 class="text-lg font-bold text-gray-800 dark:text-black">Availability</h4>
                <div class="flex justify-between">
                    <span class="justify-start">I am open for job opportunities</span>
                    <label for="hs-basic-usage" class="relative inline-block w-11 h-6 cursor-pointer justify-end">
                        <input type="checkbox" id="hs-basic-usage" class="peer sr-only">
                        <span
                            class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                        <span
                            class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                    </label>
                </div>
            </div>
            {{-- Availability --}}

        </div>
    </main>

</x-layouts.app>
