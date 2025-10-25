<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="pb-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <x-heroicon-o-key class="w-6 h-6 text-indigo-500"/>
            {{ __('Ubah Kata Sandi') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="sr-only">{{ __('Current Password') }}</label>
             <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                   <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="block w-full pl-10" autocomplete="current-password" placeholder="Kata Sandi Saat Ini" aria-label="{{ __('Current Password') }}" />
            </div>
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="sr-only">{{ __('New Password') }}</label>
             <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                   <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="block w-full pl-10" autocomplete="new-password" placeholder="Kata Sandi Baru" aria-label="{{ __('New Password') }}"/>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="sr-only">{{ __('Confirm Password') }}</label>
            <div class="relative">
                 <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                   <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400"/>
                 </div>
                 <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full pl-10" autocomplete="new-password" placeholder="Konfirmasi Kata Sandi Baru" aria-label="{{ __('Confirm Password') }}"/>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Save Button & Action Message --}}
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>
                <x-heroicon-o-check class="w-5 h-5 mr-2 -ml-1"/>
                {{ __('Simpan') }}
            </x-primary-button>

             <x-action-message class="me-3 flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400" on="password-updated">
                 <x-heroicon-s-check-circle class="w-4 h-4 text-green-500"/>
                 {{ __('Tersimpan.') }}
             </x-action-message>
        </div>
    </form>
</section>