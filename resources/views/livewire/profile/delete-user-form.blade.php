<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini jika belum ada
use Illuminate\Validation\ValidationException; // Tambahkan ini jika belum ada
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        try {
             $this->validate([
                'password' => ['required', 'string', 'current_password'],
            ]);
        } catch (ValidationException $e) {
             // Reset password field on validation error
            $this->reset('password'); 
            throw $e;
        }


        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

     /**
      * Close the modal and reset the password property.
      */
     public function closeModal(): void
     {
         $this->resetErrorBag();
         $this->reset('password');
     }
}; ?>

<section class="space-y-6">
    <header class="pb-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-red-700 dark:text-red-400 flex items-center gap-2">
             <x-heroicon-o-trash class="w-6 h-6"/>
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    {{-- Tombol untuk membuka modal --}}
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 text-sm" {{-- Tambah styling --}}
    >
        <x-heroicon-o-trash class="w-4 h-4 mr-1 -ml-1"/>
        {{ __('Hapus Akun Saya') }}
    </x-danger-button>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        {{-- [Ubah] Tambahkan wire:submit.prevent dan wire:keydown.escape --}}
        <form wire:submit="deleteUser" wire:keydown.escape="$dispatch('close')" class="p-6">

            <div class="flex items-start gap-3 mb-4">
                 <div class="flex-shrink-0 bg-red-100 dark:bg-red-900 rounded-full p-2">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600 dark:text-red-300"/>
                 </div>
                 <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Yakin ingin menghapus akun Anda?') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Setelah akun Anda dihapus, semua data akan hilang permanen. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan permanen akun Anda.') }}
                    </p>
                 </div>
            </div>

            {{-- Input Password Konfirmasi --}}
            <div class="mt-6">
                <label for="delete-password" class="sr-only">{{ __('Password') }}</label> {{-- Ubah ID agar unik --}}
                 <div class="relative">
                     <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                       <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400"/>
                     </div>
                     <x-text-input
                        wire:model="password"
                        id="delete-password" {{-- Ubah ID --}}
                        name="password"
                        type="password"
                        class="block w-full pl-10" {{-- Ubah w-3/4 menjadi w-full --}}
                        placeholder="{{ __('Kata Sandi Anda') }}"
                        aria-label="{{ __('Password') }}"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Tombol Aksi Modal --}}
            <div class="mt-6 flex justify-end gap-3">
                 {{-- [Ubah] Ganti x-on:click dengan wire:click dan panggil closeModal --}}
                <x-secondary-button wire:click="closeModal" type="button">
                    <x-heroicon-o-x-mark class="w-5 h-5 mr-1 -ml-1"/>
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="inline-flex items-center">
                     <x-heroicon-o-trash class="w-5 h-5 mr-1 -ml-1"/>
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>