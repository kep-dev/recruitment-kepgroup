<div class=" col-span-full md:col-span-full lg:col-span-9 space-y-4">
    <div
        class="col-span-full md:col-span-full lg:col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
        <strong>
            <h2 class="text-3xl text-gray-800 dark:text-slate-100">My Profile</h2>
        </strong>
    </div>

    <div
        class="col-span-9 bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl p-4 md:p-5 white:bg-neutral-900 white:border-neutral-700 white:text-neutral-400">
        <h4 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-6">Availability</h4>
        <div class="flex justify-between">
            <span class="justify-start text-gray-800 dark:text-slate-100">I am open for job opportunities</span>
            <label for="hs-basic-usage" class="relative inline-block w-11 h-6 cursor-pointer justify-end">
                <input type="checkbox" id="hs-basic-usage" class="peer sr-only">
                <span
                    class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                <span
                    class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
            </label>
        </div>
    </div>


    <livewire:frontend.profile.partials.personal-information :user="$user" />
    <livewire:frontend.profile.partials.professional-headline :user="$user" />
    <livewire:frontend.profile.partials.latest-education :user="$user" />
    <livewire:frontend.profile.partials.work-experience :user="$user" />
    <livewire:frontend.profile.partials.organization-experience :user="$user" />
    <livewire:frontend.profile.partials.training-certification :user="$user" />
    <livewire:frontend.profile.partials.achievement :user="$user" />
    <livewire:frontend.profile.partials.language :user="$user" />
    <livewire:frontend.profile.partials.applicant-skill :user="$user" />
    <livewire:frontend.profile.partials.applicant-social-media :user="$user" />
    <livewire:frontend.profile.partials.applicant-salary :user="$user" />
    <livewire:frontend.profile.partials.applicant-document :user="$user" />

    {{-- Years of Full-time Work Experience --}}
    {{-- <div class="col-span-full md:col-span-full lg:col-span-9">
        <div
            class="flex flex-col bg-white border border-gray-200 dark:bg-neutral-800 dark:border-none shadow-2xs rounded-xl">
            <div class="flex justify-between items-center rounded-t-xl py-3 px-4 md:px-5">
                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                    Years of Full-time Work Experience
                </h3>
            </div>
            <div class="p-4 md:p-5">
                <p class="text-gray-500">
                    With supporting text below as a natural lead-in to additional content.
                </p>
            </div>
        </div>
    </div> --}}
    {{-- Years of Full-time Work Experience --}}

    <x-molecules.alerts.alert />

</div>
