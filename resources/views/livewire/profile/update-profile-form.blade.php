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

    <form wire:submit.prevent="save" class="mt-6 space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Name --}}
        <div>
            <label for="name" class="sr-only">{{ __('Name') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model.live="name" id="name" name="name" type="text" class="block w-full pl-10" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
            </div>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="sr-only">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400"/>
                </div>
                <x-text-input wire:model.live="email" id="email" name="email" type="email" class="block w-full pl-10" required autocomplete="username" placeholder="Alamat Email" />
            </div>
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Additional Student Fields --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="npm" class="sr-only">NPM</label>
                <x-text-input wire:model.live="npm" id="npm" name="npm" type="text" class="block w-full" placeholder="NPM" />
                @error('npm') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="semester" class="sr-only">Semester</label>
                <x-text-input wire:model.live="semester" id="semester" name="semester" type="number" min="1" class="block w-full" placeholder="Semester" />
                @error('semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="kelas" class="sr-only">Kelas</label>
                <x-text-input wire:model.live="kelas" id="kelas" name="kelas" type="text" class="block w-full" placeholder="Kelas" />
                @error('kelas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="program_studi" class="sr-only">Program Studi</label>
                <x-text-input wire:model.live="program_studi" id="program_studi" name="program_studi" type="text" class="block w-full" placeholder="Program Studi" />
                @error('program_studi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="fakultas" class="sr-only">Fakultas</label>
                <x-text-input wire:model.live="fakultas" id="fakultas" name="fakultas" type="text" class="block w-full" placeholder="Fakultas" />
                @error('fakultas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="universitas" class="sr-only">Universitas</label>
                <x-text-input wire:model.live="universitas" id="universitas" name="universitas" type="text" class="block w-full" placeholder="Universitas" />
                @error('universitas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="wa_number" class="sr-only">Nomor WA</label>
                <x-text-input wire:model.live="wa_number" id="wa_number" name="wa_number" type="text" class="block w-full" placeholder="Nomor WA" />
                @error('wa_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="sr-only">Alamat</label>
                <textarea wire:model.live="alamat" id="alamat" name="alamat" rows="3" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Alamat"></textarea>
                @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Save Button & Action Message --}}
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button type="submit">
                <x-heroicon-o-check class="w-5 h-5 mr-2 -ml-1"/>
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</section>