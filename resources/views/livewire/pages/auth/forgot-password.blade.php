<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        // Jangan reset email agar user bisa melihat email yang dikirimi link
        // $this->reset('email'); 

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="text-center mb-6">
        <div class="flex justify-center mb-4">
            {{-- Ikon Tanda Tanya --}}
            <div class="w-12 h-12 rounded-lg bg-yellow-100 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 flex items-center justify-center">
                <x-heroicon-o-question-mark-circle class="w-7 h-7 text-yellow-600 dark:text-yellow-400"/>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Lupa Kata Sandi?
        </h1>
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi melalui email yang memungkinkan Anda memilih yang baru.') }}
    </div>

    {{-- Tampilan session status yang lebih jelas --}}
    @if (session('status'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-700 flex items-start gap-3" role="alert">
            <x-heroicon-s-check-circle class="w-5 h-5 flex-shrink-0"/>
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif


    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <div>
            <label for="email" class="sr-only">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                   <x-heroicon-o-envelope class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model="email" id="email" class="block w-full pl-10" type="email" name="email" required autofocus placeholder="Masukkan alamat email Anda" aria-label="{{ __('Email') }}" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Tombol Kirim Link --}}
        <div>
            <x-primary-button class="w-full justify-center">
                 <x-heroicon-o-paper-airplane class="w-5 h-5 mr-2 -ml-1 rotate-45"/>
                {{ __('Kirim Link Reset Password') }}
            </x-primary-button>
        </div>

         <div class="text-sm text-center">
            <a class="underline text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Kembali ke halaman login') }}
            </a>
        </div>
    </form>
</div>