<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BelajarSiko') }}</title>
     <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%234f46e5'><path stroke-linecap='round' stroke-linejoin='round' d='M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z' /><path stroke-linecap='round' stroke-linejoin='round' d='M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z' /></svg>">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{ display:none !important; }</style>
    <script>
        // Force light mode regardless of OS or saved preference
        document.documentElement.classList.remove('dark');
    </script>
    <!-- Alpine.js is required by some pages (e.g., course detail) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50 flex">

        <!-- Sidebar (hidden on mobile, visible on lg+) -->
        <aside class="hidden lg:flex lg:flex-col w-64 bg-white border-r border-gray-200 sticky top-0 h-screen">

            <!-- Logo -->
            <div class="flex items-center justify-center px-6 py-4 border-b border-gray-200 h-16">
                <a href="{{ route('dashboard') }}" wire:navigate
                    class="flex items-center gap-2 font-semibold text-gray-800">
                    <!-- Styled Logo -->
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                        </svg>
                    </div>
                    <span class="text-lg">BelajarSiko</span>
                </a>
            </div>

            <!-- Navigasi Sidebar -->
            <nav class="p-4 flex-grow">
                @php
                    // Definisikan item menu dengan ikon Heroicons (nama ikon tanpa 'outline-'/'solid-')
                    $items = [
                        [
                            'label' => 'Dashboard',
                            'route' => 'dashboard',
                            'href' => route('dashboard'),
                            'icon' => 'home',
                        ],
                        [
                            'label' => 'Kelas Saya',
                            'route' => 'student.courses',
                            'href' => route('student.courses'),
                            'icon' => 'book-open',
                        ], // Ganti route jika perlu
                        [
                            'label' => 'Tugas',
                            'route' => 'student.assignments',
                            'href' => route('student.assignments'),
                            'icon' => 'clipboard-document-list',
                        ], // Ganti route jika perlu
                        [
                            'label' => 'Sertifikat',
                            'route' => 'student.certificates',
                            'href' => route('student.certificates'),
                            'icon' => 'academic-cap',
                        ], // Ganti route jika perlu
                        // Tambahkan item admin jika diperlukan, mungkin dengan cek role
                        // ['label' => 'Kelola Kelas', 'route' => 'admin.courses.index', 'href' => route('admin.courses.index'), 'icon' => 'cog-6-tooth', 'role' => 'admin'],
                    ];
                @endphp
                <ul class="space-y-2">
                    @foreach ($items as $item)
                        {{-- Contoh cek role (jika Anda pakai Spatie) --}}
                        {{-- @if (!isset($item['role']) || auth()->user()->hasRole($item['role'])) --}}
                        <li>
                            <a href="{{ $item['href'] }}" wire:navigate @class([
                                'flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200',
                                'bg-indigo-600 text-white shadow-md' => request()->routeIs($item['route']),
                                'text-gray-600 hover:bg-indigo-50 hover:text-indigo-600' => !request()->routeIs(
                                    $item['route']),
                            ])>
                                <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="w-5 h-5" />
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                        {{-- @endif --}}
                    @endforeach
                </ul>
            </nav>
            <!-- Logout (Contoh di bawah sidebar) -->
            <div class="p-4 border-t border-gray-200 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 w-full text-left">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" />
                        <span>{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Overlay untuk Mobile dihilangkan karena sidebar disembunyikan pada mobile -->

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top Bar -->
            <header
                class="sticky top-0 bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Kiri: Hamburger (Mobile) & Header Slot (Desktop) -->
                        <div class="flex items-center">
                            <!-- Brand (mobile) -->
                            <a href="{{ route('dashboard') }}" wire:navigate class="lg:hidden flex items-center gap-2 mr-3">
                                <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                    </svg>
                                </span>
                                <span class="font-semibold text-gray-900">BelajarSiko</span>
                            </a>

                            <!-- Header Slot (Judul Halaman) -->
                            @if (isset($header))
                                <div class="hidden lg:block">
                                    {{ $header }}
                                </div>
                            @endif
                        </div>

                        <!-- Kanan: User Dropdown -->
                        <div class="flex items-center">
                            <div class="relative ml-3">
                                <div>
                                    <button onclick="toggleUserMenu(event)" type="button"
                                        class="flex text-sm bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        {{-- Ganti dengan avatar user jika ada --}}
                                        <span
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 font-semibold">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </button>
                                </div>
                                <div id="user-menu"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">

                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ Auth::user()->email }}</p>
                                    </div>

                                    <a href="{{ route('profile') }}" wire:navigate
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem" tabindex="-1">Profil Saya</a>

                                    <a href="{{ route('student.purchases') }}" wire:navigate
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem" tabindex="-1">Riwayat Pembelian</a>

                                    <!-- Logout Form -->
                                    <form method="POST" action="{{ route('logout') }}" role="none">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Header Slot (Judul Halaman untuk Mobile) -->
                    @if (isset($header))
                        <div class="lg:hidden border-t border-gray-200 py-3 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    @endif
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow p-6 pb-20 lg:pb-8">
                {{ $slot }}
            </main>

            <!-- Bottom Mobile Nav -->
            <nav class="lg:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-40">
                @php
                    $items = [
                        [
                            'label' => 'Dashboard',
                            'route' => 'dashboard',
                            'href' => route('dashboard'),
                            'icon' => 'home',
                        ],
                        [
                            'label' => 'Kelas',
                            'route' => 'student.courses',
                            'href' => route('student.courses'),
                            'icon' => 'book-open',
                        ],
                        [
                            'label' => 'Tugas',
                            'route' => 'student.assignments',
                            'href' => route('student.assignments'),
                            'icon' => 'clipboard-document-list',
                        ],
                        [
                            'label' => 'Sertifikat',
                            'route' => 'student.certificates',
                            'href' => route('student.certificates'),
                            'icon' => 'academic-cap',
                        ],
                    ];
                @endphp
                <ul class="grid grid-cols-4">
                    @foreach ($items as $item)
                        <li>
                            <a href="{{ $item['href'] }}" wire:navigate
                               @class([
                                   'flex flex-col items-center justify-center py-2 text-xs gap-1',
                                   'text-indigo-600' => request()->routeIs($item['route']),
                                   'text-gray-600' => !request()->routeIs($item['route']),
                               ])>
                                <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="w-6 h-6" />
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

        </div>
    </div>
    <x-flash-popup />
    <script>
        function toggleUserMenu(event) {
            event.stopPropagation();
            const btn = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');
            if (!btn || !menu) return;
            const hidden = menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', hidden ? 'false' : 'true');
        }
        (function () {
            const btn = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');
            if (!btn || !menu) return;
            document.addEventListener('click', function (e) {
                if (!menu.classList.contains('hidden')) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        menu.classList.add('hidden');
                        btn.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        })();
    </script>
</body>

</html>
