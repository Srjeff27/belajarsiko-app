@php
    $flash = session('flash') ?? (session('status') ? ['message' => session('status'), 'type' => 'success'] : null);
    $type = $flash['type'] ?? 'success';
    $isSuccess = $type === 'success';
    $title = $flash['title'] ?? ($isSuccess ? 'Berhasil!' : 'Terjadi Kesalahan');
    $message = $flash['message'] ?? ($isSuccess ? 'Aksi berhasil dilakukan.' : 'Silakan coba lagi.');
@endphp

@if ($flash)
    <div id="flash-popup" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-gray-900/60 dark:bg-black/70 backdrop-blur-sm" onclick="(function(){ const e=document.getElementById('flash-popup'); if(e) e.remove(); })()" aria-hidden="true"></div>

        <div class="relative bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-xl w-full max-w-sm p-6 sm:p-8 text-center border dark:border-gray-700">
            <div class="mx-auto mb-4 w-14 h-14 rounded-full flex items-center justify-center {{ $isSuccess ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900' }}">
                @if ($isSuccess)
                    <x-heroicon-s-check-circle class="w-8 h-8 text-green-600 dark:text-green-400" />
                @else
                    <x-heroicon-s-exclamation-triangle class="w-8 h-8 text-red-600 dark:text-red-400" />
                @endif
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $message }}</p>
            <div class="mt-6">
                <button onclick="(function(){ const e=document.getElementById('flash-popup'); if(e) e.remove(); })()" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-2.5 rounded-lg text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300 {{ $isSuccess ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-red-600 hover:bg-red-700 focus:ring-red-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1.5 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Oke
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            var el = document.getElementById('flash-popup');
            if (el) el.remove();
        }, 2000);
    </script>
@endif
