<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menunggu Verifikasi Pembayaran') }} {{-- Helper __() --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border-l-4 border-yellow-400 dark:border-yellow-600">
                <div class="p-6 sm:p-8 flex items-start space-x-4">
                    {{-- Ikon --}}
                    <div class="flex-shrink-0">
                        <x-heroicon-o-clock class="h-8 w-8 text-yellow-500 dark:text-yellow-400" />
                    </div>

                    {{-- Konten Teks --}}
                    <div class="flex-grow">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
                            Bukti Pembayaran Diterima
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Terima kasih! Kami telah menerima bukti pembayaran Anda. Mohon bersabar sementara tim kami melakukan verifikasi (biasanya dalam 1x24 jam kerja). Anda akan mendapatkan akses ke kelas setelah pembayaran dikonfirmasi.
                        </p>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('dashboard') }}" wire:navigate
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            <x-heroicon-s-arrow-left class="w-4 h-4 mr-2"/>
                            {{ __('Kembali ke Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>