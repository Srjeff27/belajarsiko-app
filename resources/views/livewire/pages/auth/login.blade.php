<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

       return redirect()->intended(route('dashboard'))
    ->with('flash', [
        'type' => 'success',
        'title' => 'Login Berhasil',
        'message' => 'Selamat datang kembali! Anda berhasil masuk.',
    ]);
    }
}; ?>

<div>
    <!-- Header Teks -->
    <div class="text-center mb-8">
        {{-- Logo (Konsisten dengan guest layout jika diperlukan) --}}
        {{-- Anda bisa menghapus div logo ini jika sudah puas dengan logo di guest.blade.php --}}
         <div class="flex justify-center mb-4">
             <a href="/" wire:navigate
                 class="w-12 h-12 rounded-lg bg-indigo-600 flex items-center justify-center transition-transform transform hover:scale-110">
                 <img src="{{ asset('images/logo-sb.svg') }}" alt="BelajarSiko Logo" class="w-8 h-8"/>
             </a>
         </div>
        <h1 class="text-2xl font-bold text-gray-900">
            Selamat Datang Kembali!
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            Masuk ke akun BelajarSiko Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6"> {{-- Sedikit menambah spasi --}}
        <!-- Email Address -->
        <div>
            <label for="email" class="sr-only">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model="form.email" id="email" class="block w-full pl-10" type="email"
                    name="email" required autofocus autocomplete="username" placeholder="email@contoh.com" aria-label="{{ __('Email') }}" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="sr-only">{{ __('Password') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                   <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input
                    wire:model="form.password"
                    id="password"
                    class="block w-full pl-10 pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Kata Sandi"
                    aria-label="{{ __('Password') }}"
                />

                <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md"
                        onclick="(function(btn){ const input=document.getElementById('password'); const isPwd=input.type==='password'; input.type=isPwd?'text':'password'; btn.querySelector('.icon-eye').classList.toggle('hidden', !isPwd); btn.querySelector('.icon-eye-slash').classList.toggle('hidden', isPwd); })(this)"
                        aria-label="Tampilkan/Sembunyikan password">
                    <span class="icon-eye"><x-heroicon-o-eye class="w-5 h-5" /></span>
                    <span class="icon-eye-slash hidden"><x-heroicon-o-eye-slash class="w-5 h-5" /></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-sm text-center">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('register') }}" wire:navigate>
                {{ __('Belum punya akun? Daftar di sini') }}
            </a>
        </div>
    </form>

    <!-- Divider -->
    <div class="relative flex items-center justify-center my-6">
        <div class="absolute w-full border-t border-gray-200"></div>
        <span class="relative px-3 font-medium text-gray-500 bg-white">
            ATAU
        </span>
    </div>

    <!-- Social Login Button (Bonus) -->
    <div>
        <a href="{{ route('google.redirect') }}"
            class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
            <!-- Google Icon -->
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                <path fill="#FFC107"
                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                <path fill="#FF3D00"
                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                <path fill="#4CAF50"
                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.641-3.317-11.28-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                <path fill="#1976D2"
                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.574l6.19,5.238C39.901,36.627,44,30.63,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
            </svg>
            Masuk dengan Google
        </a>
    </div>
</div>
