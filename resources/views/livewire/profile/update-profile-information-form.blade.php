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
    public string $npm = '';
    public string $semester = '';
    public string $kelas = '';
    public string $program_studi = '';
    public string $fakultas = '';
    public string $universitas = '';
    public string $wa_number = '';
    public string $alamat = '';
    public $status = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->npm = (string) ($user->npm ?? '');
        $this->semester = (string) ($user->semester ?? '');
        $this->kelas = (string) ($user->kelas ?? '');
        $this->program_studi = (string) ($user->program_studi ?? '');
        $this->fakultas = (string) ($user->fakultas ?? '');
        $this->universitas = (string) ($user->universitas ?? '');
        $this->wa_number = (string) ($user->wa_number ?? '');
        $this->alamat = (string) ($user->alamat ?? '');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        try {
            $user = Auth::user();

            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
                'npm' => ['nullable', 'string', 'max:50'],
                'semester' => ['nullable', 'integer', 'min:1', 'max:20'],
                'kelas' => ['nullable', 'string', 'max:50'],
                'program_studi' => ['nullable', 'string', 'max:100'],
                'fakultas' => ['nullable', 'string', 'max:100'],
                'universitas' => ['nullable', 'string', 'max:150'],
                'wa_number' => ['nullable', 'string', 'max:25'],
                'alamat' => ['nullable', 'string', 'max:500'],
            ]);

            // Normalize optional fields
            foreach (['npm','kelas','program_studi','fakultas','universitas','wa_number','alamat'] as $k) {
                if (array_key_exists($k, $validated)) {
                    $validated[$k] = $validated[$k] === '' ? null : $validated[$k];
                }
            }
            if (array_key_exists('semester', $validated)) {
                $validated['semester'] = ($validated['semester'] === '' || $validated['semester'] === null)
                    ? null
                    : (int) $validated['semester'];
            }

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();
            
            $this->dispatch('profile-updated', name: $user->name);
            $this->status = 'profile-updated';
            
        } catch (\Exception $e) {
            $this->addError('save', 'Terjadi kesalahan saat menyimpan profil.');
        }
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

        {{-- Additional Student Fields --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="npm" class="sr-only">NPM</label>
                <x-text-input wire:model="npm" id="npm" name="npm" type="text" class="block w-full" placeholder="NPM" />
                <x-input-error class="mt-2" :messages="$errors->get('npm')" />
            </div>
            <div>
                <label for="semester" class="sr-only">Semester</label>
                <x-text-input wire:model="semester" id="semester" name="semester" type="number" min="1" class="block w-full" placeholder="Semester" />
                <x-input-error class="mt-2" :messages="$errors->get('semester')" />
            </div>
            <div>
                <label for="kelas" class="sr-only">Kelas</label>
                <x-text-input wire:model="kelas" id="kelas" name="kelas" type="text" class="block w-full" placeholder="Kelas" />
                <x-input-error class="mt-2" :messages="$errors->get('kelas')" />
            </div>
            <div>
                <label for="program_studi" class="sr-only">Program Studi</label>
                <x-text-input wire:model="program_studi" id="program_studi" name="program_studi" type="text" class="block w-full" placeholder="Program Studi" />
                <x-input-error class="mt-2" :messages="$errors->get('program_studi')" />
            </div>
            <div>
                <label for="fakultas" class="sr-only">Fakultas</label>
                <x-text-input wire:model="fakultas" id="fakultas" name="fakultas" type="text" class="block w-full" placeholder="Fakultas" />
                <x-input-error class="mt-2" :messages="$errors->get('fakultas')" />
            </div>
            <div>
                <label for="universitas" class="sr-only">Universitas</label>
                <x-text-input wire:model="universitas" id="universitas" name="universitas" type="text" class="block w-full" placeholder="Universitas" />
                <x-input-error class="mt-2" :messages="$errors->get('universitas')" />
            </div>
            <div>
                <label for="wa_number" class="sr-only">Nomor WA</label>
                <x-text-input wire:model="wa_number" id="wa_number" name="wa_number" type="text" class="block w-full" placeholder="Nomor WA" />
                <x-input-error class="mt-2" :messages="$errors->get('wa_number')" />
            </div>
            <div class="md:col-span-2">
                <label for="alamat" class="sr-only">Alamat</label>
                <textarea wire:model="alamat" id="alamat" name="alamat" rows="3" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Alamat"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>
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
