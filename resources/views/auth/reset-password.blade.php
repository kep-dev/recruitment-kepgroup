<x-layouts.guest title="Lupa Password">
    <div class="max-w-[560px] w-full mx-auto mt-10">
        <div class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-6 sm:p-7">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Atur ulang kata sandi</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                        Masukkan email dan kata sandi baru kamu di bawah ini.
                    </p>
                </div>

                {{-- Error umum --}}
                @if ($errors->any())
                    <div
                        class="mt-5 text-sm rounded-lg px-3 py-2 bg-red-100 text-red-800 dark:bg-red-400/10 dark:text-red-300">
                        {{ __('Periksa kembali isian kamu.') }}
                    </div>
                @endif

                <div class="mt-6">
                    <form method="POST" action="{{ route('password.update') }}" x-data="{ sending: false }"
                        x-on:submit="sending=true">
                        @csrf
                        {{-- token dari url --}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="grid gap-y-4">
                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm mb-2 dark:text-white">Alamat email</label>
                                <input id="email" type="email" name="email"
                                    value="{{ old('email', $request->email) }}" required autofocus
                                    class="py-2.5 sm:py-3 px-4 block w-full rounded-lg border border-gray-200 sm:text-sm
                       focus:border-blue-500 focus:ring-blue-500
                       disabled:opacity-50 disabled:pointer-events-none
                       dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                @error('email')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label for="password" class="block text-sm mb-2 dark:text-white">Kata sandi baru</label>
                                <input id="password" type="password" name="password" required
                                    autocomplete="new-password"
                                    class="py-2.5 sm:py-3 px-4 block w-full rounded-lg border border-gray-200 sm:text-sm
                       focus:border-blue-500 focus:ring-blue-500
                       disabled:opacity-50 disabled:pointer-events-none
                       dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                @error('password')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Konfirmasi
                                    kata sandi baru</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    autocomplete="new-password"
                                    class="py-2.5 sm:py-3 px-4 block w-full rounded-lg border border-gray-200 sm:text-sm
                       focus:border-blue-500 focus:ring-blue-500
                       disabled:opacity-50 disabled:pointer-events-none
                       dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            {{-- Tombol Simpan --}}
                            <button type="submit"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg
                     border border-transparent bg-blue-600 text-white hover:bg-blue-700
                     focus:outline-hidden focus:bg-blue-700
                     disabled:opacity-50 disabled:pointer-events-none"
                                :disabled="sending">
                                <svg x-show="sending" class="size-4 animate-spin -ms-1" viewBox="0 0 24 24"
                                    fill="none" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 0 1 8-8v4A4 4 0 0 0 8 12H4z" />
                                </svg>
                                <span x-text="sending ? 'Menyimpan...' : 'Simpan kata sandi baru'"></span>
                            </button>

                            <p class="text-center text-sm text-gray-600 dark:text-neutral-400">
                                <a href="{{ route('login') }}"
                                    class="text-blue-600 hover:underline font-medium dark:text-blue-500">
                                    Kembali ke login
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
