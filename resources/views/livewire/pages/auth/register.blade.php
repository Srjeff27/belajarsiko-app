<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Buat user dengan data yang divalidasi
        $user = User::create($validated);

        // Kirim event (untuk verifikasi email, dll.)
        event(new Registered($user));

        // Tetapkan peran 'student' menggunakan Spatie
        // Pastikan Anda sudah menjalankan seeder untuk membuat role 'student'
        $user->assignRole('student');

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('flash', [
                'type' => 'success',
                'title' => 'Oh Yeah!',
                'message' => 'Pendaftaran berhasil. Anda sudah masuk.',
            ]);
    }
}; ?>

<div>
    <div class="text-center">
        <div class="flex justify-center mb-4">
            <a href="/" wire:navigate
                class="w-12 h-12 rounded-lg bg-indigo-600 flex items-center justify-center transition-transform transform hover:scale-110">
                <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                </svg>
            </a>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Buat Akun Baru
        </h1>
        <p class="mt-2 text-sm text-gray-600">
            Daftar gratis untuk memulai perjalanan belajarmu.
        </p>
    </div>

    <form wire:submit="register" class="mt-8 space-y-6">
        <div>
            <label for="name" class="sr-only">{{ __('Name') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <!-- Updated Heroicon (UserIcon) -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <x-text-input wire:model="name" id="name" class="block w-full pl-10" type="text" name="name"
                    required autofocus autocomplete="name" placeholder="Nama Lengkap" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="sr-only">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <!-- Updated Heroicon (EnvelopeIcon) -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <x-text-input wire:model="email" id="email" class="block w-full pl-10" type="email" name="email"
                    required autocomplete="username" placeholder="email@contoh.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="sr-only">{{ __('Password') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <!-- Updated Heroicon (LockClosedIcon) -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="password"
                    id="password"
                    class="block w-full pl-10 pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Kata Sandi" />

                <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md"
                        onclick="(function(btn){ const input=document.getElementById('password'); const isPwd=input.type==='password'; input.type=isPwd?'text':'password'; btn.querySelector('.icon-eye').classList.toggle('hidden', !isPwd); btn.querySelector('.icon-eye-slash').classList.toggle('hidden', isPwd); })(this)"
                        aria-label="Tampilkan/Sembunyikan password">
                    <span class="icon-eye"><x-heroicon-o-eye class="w-5 h-5" /></span>
                    <span class="icon-eye-slash hidden"><x-heroicon-o-eye-slash class="w-5 h-5" /></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="sr-only">{{ __('Confirm Password') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <!-- Updated Heroicon (LockClosedIcon) -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    class="block w-full pl-10 pr-10"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Konfirmasi Kata Sandi" />

                <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md"
                        onclick="(function(btn){ const input=document.getElementById('password_confirmation'); const isPwd=input.type==='password'; input.type=isPwd?'text':'password'; btn.querySelector('.icon-eye').classList.toggle('hidden', !isPwd); btn.querySelector('.icon-eye-slash').classList.toggle('hidden', isPwd); })(this)"
                        aria-label="Tampilkan/Sembunyikan password">
                    <span class="icon-eye"><x-heroicon-o-eye class="w-5 h-5" /></span>
                    <span class="icon-eye-slash hidden"><x-heroicon-o-eye-slash class="w-5 h-5" /></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
                {{ __('Buat Akun Saya') }}
            </x-primary-button>
        </div>

        <div class="text-sm text-center">
            <a class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Sudah punya akun? Masuk di sini') }}
            </a>
        </div>
    </form>

    <div class="relative flex items-center justify-center my-6">
        <div class="absolute w-full border-t border-gray-200"></div>
        <span class="relative px-3 font-medium text-sm text-gray-500 bg-white">
            ATAU
        </span>
    </div>

    <div>

        <a href="{{ route('google.redirect') }}"
            class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-300">

            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px"
                height="48px">

                <path fill="#FFC107"
                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />

                <path fill="#FF3D00"
                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />

                <path fill="#4CAF50"
                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.641-3.317-11.28-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />

                <path fill="#1976D2"
                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.574l6.19,5.238C39.901,36.627,44,30.63,44,24C44,22.659,43.862,21.35,43.611,20.083z" />

            </svg>

            Daftar dengan Google

        </a>

    </div>

</div>
