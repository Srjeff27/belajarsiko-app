@php
    // Logika PHP Anda sudah bagus, tidak perlu diubah.
    $flash = session('flash') ?? (session('status') ? ['message' => session('status'), 'type' => 'success'] : null);
    $type = $flash['type'] ?? 'success';
    $isSuccess = $type === 'success';

    // Kita bisa sederhanakan title/message default di sini
    $title = $flash['title'] ?? ($isSuccess ? 'Berhasil!' : 'Terjadi Kesalahan');
    $message = $flash['message'] ?? 'Aksi berhasil dilakukan.';
@endphp

@if ($flash)
    {{-- 
      Wrapper untuk Toast. 
      Diposisikan di kanan-atas. 
      Anda bisa ganti 'top-6 right-6' dengan 'bottom-6 right-6' jika lebih suka di bawah.
    --}}
    <div id="flash-toast" class="fixed top-6 right-6 z-50 w-full max-w-sm">
        
        {{-- Card Notifikasi --}}
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 dark:ring-gray-700">
            <div class="flex items-start p-4">
                
                {{-- Icon Area --}}
                <div class="flex-shrink-0">
                    @if ($isSuccess)
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-100 dark:bg-green-900">
                            {{-- Menggunakan versi 'outline' agar lebih ringan --}}
                            <x-heroicon-o-check-circle class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                    @else
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-100 dark:bg-red-900">
                            <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-600 dark:text-red-400" />
                        </div>
                    @endif
                </div>

                {{-- Konten Teks (Title & Message) --}}
                <div class="ml-3 w-0 flex-1">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        {{ $title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ $message }}
                    </p>
                </div>

                {{-- Tombol Close 'X' --}}
                <div class="ml-4 flex-shrink-0">
                    <button 
                        type="button" 
                        onclick="(function(){ const e=document.getElementById('flash-toast'); if(e) e.remove(); })()"
                        class="inline-flex text-gray-400 bg-transparent rounded-md hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-blue-500"
                    >
                        <span class="sr-only">Tutup</span>
                        <x-heroicon-s-x-mark class="w-5 h-5" />
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Script auto-dismiss. 4 detik (4000ms) lebih nyaman untuk dibaca. --}}
    <script>
        setTimeout(function () {
            var el = document.getElementById('flash-toast');
            if (el) el.remove();
        }, 4000); // <-- Diperpanjang jadi 4 detik
    </script>
@endif