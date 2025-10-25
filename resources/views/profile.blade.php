<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Saya') }} </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Kartu Update Informasi Profil --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    {{-- Judul Section (Opsional, bisa ditambahkan di dalam komponen Livewire) --}}
                    {{-- <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Profil</h3> --}}
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Kartu Update Password --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                     {{-- Judul Section (Opsional) --}}
                    {{-- <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ubah Kata Sandi</h3> --}}
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- Kartu Hapus Akun --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                     {{-- Judul Section (Opsional) --}}
                    {{-- <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Hapus Akun</h3> --}}
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>