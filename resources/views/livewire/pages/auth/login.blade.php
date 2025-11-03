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

{{-- x-data untuk modal & toggle password. Wrapper untuk animasi --}}
<div x-data="{ showPasswordModal: false }" class="animate-fade-in-up">

    {{-- Blok Style untuk Animasi dan x-cloak --}}
    <style>
        [x-cloak] { display: none !important; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        /* Kelas ini akan membuat elemen mulai transparan dan dianimasikan oleh keyframe */
        .animate-fade-in {
            opacity: 0; 
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>

    <div class="text-center mb-8">
        {{-- Logo dengan animasi --}}
        <div class="flex justify-center mb-4 animate-fade-in" style="animation-delay: 100ms;">
            <a href="/" wire:navigate
                class="w-12 h-12 rounded-lg bg-indigo-600 flex items-center justify-center transition-transform transform hover:scale-110">
                <img src="{{ asset('images/logo-sb.svg') }}" alt="BelajarSiko Logo" class="w-8 h-8"/>
            </a>
        </div>
        {{-- Judul dengan animasi --}}
        <h1 class="text-2xl font-bold text-gray-900 animate-fade-in" style="animation-delay: 200ms;">
            Selamat Datang Kembali!
        </h1>
        {{-- Subjudul dengan animasi --}}
        <p class="mt-1 text-sm text-gray-600 animate-fade-in" style="animation-delay: 300ms;">
            Masuk ke akun BelajarSiko Anda.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Form dengan animasi --}}
    <form wire:submit="login" class="space-y-6 animate-fade-in" style="animation-delay: 400ms;">
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

        {{-- [INI BAGIAN YANG DIPERBAIKI] --}}
        <div x-data="{ showPassword: false }">
            <label for="password" class="sr-only">{{ __('Password') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input
                    wire:model="form.password"
                    id="password"
                    class="block w-full pl-10 pr-10"
                    
                    {{-- [PERBAIKAN] Menggunakan x-bind:type agar diproses oleh Alpine.js --}}
                    x-bind:type="showPassword ? 'text' : 'password'" 
                    
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Kata Sandi"
                    aria-label="{{ __('Password') }}"
                />
                
                {{-- Tombol toggle dikontrol oleh Alpine --}}
                <button type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md"
                        aria-label="Tampilkan/Sembunyikan password">
                    <span x-show="!showPassword"><x-heroicon-o-eye class="w-5 h-5" /></span>
                    <span x-show="showPassword" x-cloak><x-heroicon-o-eye-slash class="w-5 h-5" /></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>
        {{-- [AKHIR BAGIAN YANG DIPERBAIKI] --}}

        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                {{-- Tombol yang memicu modal --}}
                <button type="button" 
                        @click.prevent="showPasswordModal = true"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Lupa Password?') }}
                </button>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="text-sm text-center">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('register') }}" wire:navigate>
                {{ __('Belum punya akun? Daftar di sini') }}
            </a>
        </div>
    </form>

    <div class="relative flex items-center justify-center my-6 animate-fade-in" style="animation-delay: 500ms;">
        <div class="absolute w-full border-t border-gray-200"></div>
        <span class="relative px-3 font-medium text-gray-500 bg-white">
            ATAU
        </span>
    </div>

    <div class="animate-fade-in" style="animation-delay: 600ms;">
        <a href="{{ route('google.redirect') }}"
            class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
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

    {{-- Modal "Lupa Password" (Overlay) --}}
    <div x-show="showPasswordModal" 
         x-cloak
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40"
         aria-hidden="true">
    </div>

    {{-- Modal "Lupa Password" (Konten) --}}
    <div x-show="showPasswordModal" 
         x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        
        <div @click.outside="showPasswordModal = false" class="relative bg-white rounded-2xl shadow-xl p-6 pt-5 text-center max-w-sm mx-auto">
            {{-- Ikon --}}
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                <x-heroicon-o-chat-bubble-left-right class="h-6 w-6 text-green-600"/>
            </div>
            <div class="mt-3 text-center sm:mt-4">
                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Perlu Reset Password?</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-600">
                        Silakan hubungi admin kami melalui WhatsApp untuk bantuan lebih lanjut.
                    </p>
                </div>
            </div>
            {{-- Tombol Aksi --}}
            <div class="mt-5 sm:mt-6 space-y-3">
                <a href="https://wa.me/6282374411745?text=Halo%20admin%20BelajarSiko%2C%20saya%20lupa%20password%20akun%20saya." 
                   target="_blank"
                   class="inline-flex w-full justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all transform hover:scale-105">
                    {{-- Ikon WA Kustom --}}
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.504.658.67-2.431-.155-.248a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                    Hubungi Admin (WA)
                </a>
                <button type="button" 
                        @click="showPasswordModal = false"
                        class="inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>