<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="pb-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
             <x-heroicon-o-user-circle class="w-6 h-6 text-indigo-500"/>
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        {{-- Name --}}
        <div>
            <label for="name" class="sr-only">{{ __('Name') }}</label>
             <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model="name" id="name" name="name" type="text" class="block w-full pl-10" required autofocus autocomplete="name" placeholder="Nama Lengkap" aria-label="{{ __('Name') }}" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="sr-only">{{ __('Email') }}</label>
             <div class="relative">
                 <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400"/>
                 </div>
                 <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full pl-10" required autocomplete="username" placeholder="Alamat Email" aria-label="{{ __('Email') }}" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Email Verification Notice --}}
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-gray-700 border border-yellow-200 dark:border-yellow-600 rounded-md">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                             <x-heroicon-s-exclamation-triangle class="h-5 w-5 text-yellow-500 dark:text-yellow-400" />
                        </div>
                        <div class="ml-3">
                             <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ __('Alamat email Anda belum terverifikasi.') }}
                            </p>
                             <div class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                                <button wire:click.prevent="sendVerification" class="underline hover:text-yellow-900 dark:hover:text-yellow-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-700 font-medium">
                                    {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                </button>
                             </div>
                         </div>
                     </div>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-medium text-sm text-green-600 dark:text-green-400 flex items-center gap-1">
                             <x-heroicon-s-check-circle class="w-4 h-4"/>
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save Button & Action Message --}}
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>
                 <x-heroicon-o-check class="w-5 h-5 mr-2 -ml-1"/>
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

             {{-- Pesan "Saved." akan muncul di sini --}}
            <x-action-message class="me-3 flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400" on="profile-updated">
                 <x-heroicon-s-check-circle class="w-4 h-4 text-green-500"/>
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>