<x-layouts.app>

    <main class="w-full max-w-7xl md:pt-0 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-9 gap-4">
            @include('profile.side-profile')
            <div
                class="col-start-4 col-span-9 bg-white border border-white-200 shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <strong>
                    <h2 class="text-3xl dark:text-black">Setting</h2>
                </strong>
            </div>

            {{-- Talentics Subscription Email --}}
            <div
                class="col-start-4 col-span-9 bg-white border border-white-200 shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
                <h4 class="text-lg font-bold text-gray-800 dark:text-black">Talentics Subscription Email</h4>
                <div class="flex justify-between">
                    <h1 class="justify-start">Event & Job Opportunities</h1>
                    <label for="hs-basic-usage" class="relative inline-block w-11 h-6 cursor-pointer justify-end">
                        <input type="checkbox" id="hs-basic-usage" class="peer sr-only">
                        <span
                            class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                        <span
                            class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                    </label>
                    <span>Information about featured events and job listings.</span>
                </div>
            </div>
            {{-- Talentics Subscription Email --}}

            {{-- Latest Education --}}
            <div class="col-start-4 col-span-9">
                <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl">
                    <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Account Management
                        </h3>
                    </div>
                    <div class="p-4 md:p-5">
                        <a href="" style="color: red">Delete My Account</a>
                    </div>
                </div>
            </div>
            {{-- Latest Education --}}
            
        </div>
    </main>

</x-layouts.app>
