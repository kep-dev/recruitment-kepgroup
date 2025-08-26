<x-layouts.guest>
    <!-- CARD: LEBAR DIBATASI & DI-TENGAH -->
    <div
        class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-2xs
              dark:bg-neutral-900 dark:border-neutral-700">
        <div class="p-5 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                    Don't have an account yet?
                    <a class="text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500"
                        href="{{ route('register') }}">Sign up here</a>
                </p>
            </div>

            <div class="mt-5">
                <!-- Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="grid gap-y-4">
                        <div>
                            <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                            <div class="relative">
                                <input type="email" id="email" name="email"
                                    class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500
                         disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-100
                         dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    required>
                            </div>
                        </div>

                        <div>
                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                                <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500"
                                    href="../examples/html/recover-account.html">Forgot password?</a>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500
                         disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-100
                         dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    required>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500
                       dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="remember-me" class="ms-3 text-sm dark:text-white">Remember me</label>
                        </div>

                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent
                     bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Sign in
                        </button>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</x-layouts.guest>
