<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BelajarSiko') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-sbu.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{ display:none !important; }</style>
    <script>
        // Force light mode regardless of device theme
        document.documentElement.classList.remove('dark');
    </script>
    <!-- No Alpine needed; interactions handled with small inline JS in components -->
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Mobile brand header (top-left) -->
    <div class="sm:hidden fixed top-4 left-4 z-20">
        <a href="/" class="flex items-center gap-2" wire:navigate>
            <span class="flex items-center gap-1 font-semibold text-gray-800">
                 <img src="{{ asset('images/logo-sbu.svg') }}" alt="BelajarSiko Logo"
                            class="w-9 h-9 object-contain" />
            </span>
            <span class="text-xl font-bold text-[#4F47E6] leading-none">BelajarSiko</span>
        </a>
    </div>
    <div
        class="min-h-screen flex flex-col justify-center items-center pt-20 pb-6 bg-gradient-to-br from-indigo-50 via-white to-blue-100 px-4 sm:px-0">
        {{-- [Ubah] Hapus sm:justify-center, hapus sm:pt-0 --}}

        <div
            class="w-full sm:max-w-md p-8 bg-white shadow-xl overflow-hidden rounded-2xl">
            {{-- [Ubah] Hapus sm:rounded-2xl, jadikan rounded-2xl saja --}}
            {{ $slot }}
        </div>
    </div>
    <x-flash-popup />
</body>

</html>
