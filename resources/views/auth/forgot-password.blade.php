<x-layouts.guest title="Lupa Password">
    <div class="max-w-[560px] w-full mx-auto mt-10">
        <div class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-6 sm:p-7">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Lupa kata sandi?</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                        Masukkan email kamu. Kami akan kirim tautan untuk mengatur ulang kata sandi.
                    </p>
                </div>

                {{-- Alert sukses (jika ada) --}}
                @if (session('status'))
                    <div
                        class="mt-5 text-sm rounded-lg px-3 py-2 bg-emerald-100 text-emerald-800 dark:bg-emerald-400/10 dark:text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Alert error umum (opsional) --}}
                @if ($errors->any())
                    <div
                        class="mt-5 text-sm rounded-lg px-3 py-2 bg-red-100 text-red-800 dark:bg-red-400/10 dark:text-red-300">
                        {{ __('Periksa kembali isian kamu.') }}
                    </div>
                @endif

                <div class="mt-6">
                    <form method="POST" action="{{ route('password.email') }}" x-data="{ sending: false }"
                        x-on:submit="sending=true">
                        @csrf

                        <div class="grid gap-y-4">
                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm mb-2 dark:text-white">Alamat email</label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        required autocomplete="email"
                                        class="py-2.5 sm:py-3 px-4 block w-full rounded-lg border border-gray-200 sm:text-sm
                         focus:border-blue-500 focus:ring-blue-500
                         disabled:opacity-50 disabled:pointer-events-none
                         dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        aria-describedby="email-error">
                                    @error('email')
                                        <div class="absolute inset-y-0 end-0 pe-3 flex items-center pointer-events-none">
                                            <svg class="size-5 text-red-500" viewBox="0 0 16 16" fill="currentColor"
                                                aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('email')
                                    <p id="email-error" class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tombol Kirim --}}
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
                                <span x-text="sending ? 'Mengirim...' : 'Kirim link reset password'"></span>
                            </button>

                            {{-- Link kembali ke login --}}
                            <p class="text-center text-sm text-gray-600 dark:text-neutral-400">
                                Sudah ingat kata sandi?
                                <a href="{{ route('login') }}"
                                    class="text-blue-600 hover:underline font-medium dark:text-blue-500">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
