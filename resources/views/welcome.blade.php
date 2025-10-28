<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BelajarSiko | Platform Belajar Online Terdepan</title> {{-- [Ubah] spasi --}}

    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%234f46e5'><path stroke-linecap='round' stroke-linejoin='round' d='M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z' /><path stroke-linecap='round' stroke-linejoin='round' d='M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z' /></svg>">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Logika Vite Kustom Anda --}}
    @php
        $isProduction = app()->environment('production');
        $manifestPath = $isProduction ? '../public_html/build/manifest.json' : public_path('build/manifest.json');
    @endphp

    @if ($isProduction && file_exists($manifestPath))
        @php $manifest = json_decode(file_get_contents($manifestPath), true); @endphp
        <link rel="stylesheet" href="{{ config('app.url') }}/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="{{ config('app.url') }}/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        {{-- @viteReactRefresh --}} {{-- Hapus jika tidak pakai React --}}
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    @endif

    <style>
        .gradient-bg {
            background: radial-gradient(1200px 600px at 10% 10%, rgba(99, 102, 241, 0.25), transparent 60%),
                radial-gradient(1000px 600px at 90% 10%, rgba(236, 72, 153, 0.25), transparent 60%),
                linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #0ea5e9 100%);
        }

        .card-hover {
            transition: all 0.3s ease-in-out;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.25);
        }

        .mobile-menu-hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            border-top-width: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        .mobile-menu-visible {
            max-height: 520px;
            transition: max-height 0.4s ease-in;
            border-top-width: 1px;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body class="antialiased font-sans bg-gray-50 text-gray-800">

    <div id="announce" class="bg-indigo-600 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between text-sm">
            <p class="flex items-center gap-2">
                {{-- [Ubah] Ganti SVG dengan Heroicon --}}
                <x-heroicon-s-information-circle class="w-4 h-4" />
                Diskon Mahasiswa & sertifikat digital untuk kelas pemula.<span class="font-semibold">daftar gratis
                    sekarang!</span>
            </p>
            <button id="close-announce" class="p-1/2 rounded hover:bg-white/10">
                <span class="sr-only">Tutup</span>
                {{-- [Ubah] Ganti SVG dengan Heroicon --}}
                <x-heroicon-s-x-mark class="w-5 h-5" />
            </button>
        </div>
    </div>

    <header id="header"
        class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 transition-shadow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="flex items-center space-x-2" wire:navigate> {{-- Tambah wire:navigate --}}
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-md">
                        {{-- [Ubah] Ganti SVG dengan Heroicon --}}
                        <x-heroicon-s-academic-cap class="w-6 h-6 text-white" />
                    </div>
                    <span class="text-xl font-bold text-gray-900">BelajarSiko</span> {{-- [Ubah] spasi --}}
                </a>

                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-600 hover:text-indigo-600 font-medium">Beranda</a>
                    <a href="#fitur" class="text-gray-600 hover:text-indigo-600 font-medium">Fitur</a>
                    <a href="#kursus" class="text-gray-600 hover:text-indigo-600 font-medium">Kursus</a>
                    <a href="#testimoni" class="text-gray-600 hover:text-indigo-600 font-medium">Testimoni</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">Daftar
                                    Gratis</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-600 hover:text-indigo-600">
                    <span class="sr-only">Buka menu</span>
                    {{-- [Ubah] Ganti SVG dengan Heroicon --}}
                    <x-heroicon-o-bars-3 id="hamburger-icon" class="h-6 w-6" />
                    <x-heroicon-o-x-mark id="close-icon" class="h-6 w-6 hidden" />
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden mobile-menu-hidden border-gray-200 bg-white/95 backdrop-blur">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#beranda"
                    class="mobile-menu-link block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Beranda</a>
                <a href="#fitur"
                    class="mobile-menu-link block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Fitur</a>
                <a href="#kursus"
                    class="mobile-menu-link block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Kursus</a>
                <a href="#testimoni"
                    class="mobile-menu-link block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Testimoni</a>
            </div>
            <div class="border-t border-gray-200 px-4 py-4 space-y-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center text-gray-600 hover:text-indigo-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all">Daftar
                                Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main>
        <section id="beranda" class="gradient-bg text-white pt-20 pb-16 md:pt-28 md:pb-24 relative overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                    <div class="md:w-1/2 mb-10 md:mb-0 text-center md:text-left">
                        <div
                            class="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1.5 text-sm mb-4 ring-1 ring-white/20 glass">
                            {{-- Tambah class 'glass' --}}
                            {{-- [Ubah] Ganti SVG dengan Heroicon --}}
                            <x-heroicon-s-sparkles class="w-4 h-4 text-yellow-300" />
                            <span>Akses materi premium + komunitas kampus</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                            Belajar Lebih Mudah
                            dengan <span class="text-yellow-300">BelajarSiko</span></h1> {{-- [Ubah] spasi --}}
                        <p class="text-lg md:text-xl mb-8 text-indigo-100">Ribuan materi berkualitas, mentoring ringan,
                            dan sertifikat penyelesaian. BelajarSiko cocok untuk <span
                                class="font-semibold">mahasiswa</span> yang ingin upgrade skill cepat.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                            <a href="{{ Route::has('register') ? route('register') : '#' }}"
                                class="bg-white text-indigo-700 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 transform hover:scale-105">Mulai
                                Belajar Gratis</a>
                            <a href="#kursus"
                                class="border-2 border-white/80 text-white hover:bg-white/10 px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 transform hover:scale-105">Lihat
                                Kursus</a>
                        </div>
                        <div class="mt-8 grid grid-cols-3 gap-4 max-w-md mx-auto md:mx-0">
                            <div class="text-center">
                                <div class="text-2xl font-bold">100+</div>
                                <div class="text-xs text-indigo-100">Mahasiswa</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">20+</div>
                                <div class="text-xs text-indigo-100">Kursus</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">4.9/5</div>
                                <div class="text-xs text-indigo-100">Rating</div>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="relative w-full max-w-lg">
                            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                                alt="Ilustrasi belajar online" class="rounded-2xl shadow-2xl w-full object-cover">
                            <div
                                class="absolute -bottom-6 -left-6 bg-white/90 dark:bg-gray-800/90 text-gray-800 dark:text-white backdrop-blur-md rounded-xl shadow-xl p-4 flex items-center gap-3 ring-1 ring-black/5">
                                {{-- [Ubah] Dark mode & styling --}}
                                <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900">
                                    {{-- [Ubah] Ganti SVG dengan Heroicon --}}
                                    <x-heroicon-s-book-open class="w-5 h-5 text-indigo-600 dark:text-indigo-300" />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold dark:text-gray-100">Kelas aktif</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">+25 sesi minggu ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-20 lg:py-24 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3">Mengapa Memilih BelajarSiko?
                    </h2> {{-- [Ubah] spasi --}}
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Didesain untuk pengalaman belajar terbaik, yang
                        fokus pada mahasiswa yang ingin <span class="font-semibold text-indigo-600">cepat paham</span>
                        dan <span class="font-semibold text-indigo-600">siap proyek</span>.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- [Ubah] Ganti SVG dengan Komponen Blade Icon --}}
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5 card-hover">
                        {{-- [Ubah] styling ring --}}
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <x-heroicon-o-user-group class="h-6 w-6 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Instruktur Berpengalaman</h3>
                        <p class="text-gray-600">Belajar dari praktisi, materi ditata runtut dengan contoh nyata.</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5 card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <x-heroicon-o-lock-closed class="h-6 w-6 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Akses Seumur Hidup</h3>
                        <p class="text-gray-600">Beli sekali, belajar selamanya. cocok untuk revisi menjelang ujian.
                        </p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5 card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <x-heroicon-o-sparkles class="h-6 w-6 text-indigo-600" /> {{-- Ganti ikon --}}
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Pembelajaran Interaktif</h3>
                        <p class="text-gray-600">Kuis, tugas, & forum diskusi. belajar aktif biar nempel.</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5 card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <x-heroicon-o-check-badge class="h-6 w-6 text-indigo-600" /> {{-- Ganti ikon --}}
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Sertifikat Resmi</h3>
                        <p class="text-gray-600">Tingkatkan portofolio & LinkedIn dengan bukti kompetensi.</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5 card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <x-heroicon-o-arrow-trending-up class="h-6 w-6 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Konten Terupdate</h3>
                        <p class="text-gray-600">Materi mengikuti tren industri — anti ketinggalan zaman.</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5 card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <x-heroicon-o-chat-bubble-left-right class="h-6 w-6 text-indigo-600" />
                            {{-- Ganti ikon --}}
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Komunitas Belajar</h3>
                        <p class="text-gray-600">Belajar bareng teman kampus — lebih semangat & konsisten.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kursus" class="py-20 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3">Kursus Populer</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Pilih jalan ninjamu. Mulai dari basic sampai
                        siap projek nyata.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-900/5 card-hover">
                        {{-- [Ubah] styling ring --}}
                        <img class="w-full h-48 object-cover"
                            src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="Web Development Course">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-bold text-gray-900">Web Development Mastery</h3>
                                <span
                                    class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Populer</span>
                            </div>
                            <p class="text-gray-600 mb-4">Frontend dan Backend modern dari nol. HTML/CSS/JS ke
                                framework.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                                    <span class="ml-1 text-gray-600">4.9 (1.2k)</span>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">Rp 299.000</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-900/5 card-hover">
                        <img class="w-full h-48 object-cover"
                            src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="Data Science Course">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-bold text-gray-900">Data Science Fundamentals</h3>
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Baru</span>
                            </div>
                            <p class="text-gray-600 mb-4">Statistik + Python + visualisasi. Cocok untuk tugas kampus &
                                riset.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                                    <span class="ml-1 text-gray-600">4.8 (890)</span>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">Rp 399.000</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-900/5 card-hover">
                        <img class="w-full h-48 object-cover"
                            src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="UI/UX Design Course">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-bold text-gray-900">UI/UX Design Principles</h3>
                                <span
                                    class="bg-pink-100 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Terlaris</span>
                            </div>
                            <p class="text-gray-600 mb-4">Bangun sense desain, prototyping, dan uji pengguna.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                                    <span class="ml-1 text-gray-600">4.9 (1.5k)</span>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">Rp 249.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ url('/courses') }}"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold">
                        Lihat Semua Kursus
                        <x-heroicon-o-arrow-right class="h-5 w-5 ml-1" />
                    </a>
                </div>
            </div>
        </section>

        <section id="testimoni" class="py-20 lg:py-24 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3">Apa Kata Mereka?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Cerita nyata dari mereka yang sudah merasakan
                        percepatan belajar.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold flex-shrink-0">
                                A</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Ahmad Rizki</h4>
                                <p class="text-gray-500 text-sm">Mahasiswa Teknik Informatika</p>
                                {{-- Ubah --}}
                            </div>
                        </div>
                        <div class="flex mb-3">
                            @for ($i = 0; $i < 5; $i++)
                                <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                            @endfor
                        </div>
                        <p class="text-gray-600 italic">“Kurikulumnya rapi dan langsung to the point. Dari nol sekarang
                            bisa deploy website profesional. Mantap!”</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold flex-shrink-0">
                                S</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Sari Dewi</h4>
                                <p class="text-gray-500 text-sm">Mahasiswi DKV</p> {{-- Ubah --}}
                            </div>
                        </div>
                        <div class="flex mb-3">
                            @for ($i = 0; $i < 5; $i++)
                                <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                            @endfor
                        </div>
                        <p class="text-gray-600 italic">“Materinya ringan, banyak latihan. Cocok banget buat pemula
                            yang mau pindah karier.”</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold flex-shrink-0">
                                B</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Budi Pratama</h4>
                                <p class="text-gray-500 text-sm">Mahasiswa Statistika</p> {{-- Ubah --}}
                            </div>
                        </div>
                        <div class="flex mb-3">
                            @for ($i = 0; $i < 5; $i++)
                                <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                            @endfor
                        </div>
                        <p class="text-gray-600 italic">“Langsung kepake buat kerja. Modul data science-nya praktikal
                            dan to the point.”</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 lg:py-24 gradient-bg text-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-6">Siap Memulai Perjalanan Belajar
                    Anda?</h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto text-indigo-100">Gabung sekarang dan rasakan bedanya:
                    kurikulum fokus praktik, mentor responsif, dan komunitas aktif.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}"
                        class="bg-white text-indigo-700 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105">Daftar
                        Sekarang</a>
                    <a href="{{ url('/courses') }}"
                        class="border-2 border-white text-white hover:bg-white/10 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105">Lihat
                        Kursus Gratis</a> {{-- Ubah link --}}
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white pt-16 pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                <!-- Brand + Social -->
                <div class="lg:col-span-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14.25L3.75 9.75 12 5.25l8.25 4.5-8.25 4.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 10.5v3.75A8.25 8.25 0 0012 21a8.25 8.25 0 005.25-6.75V10.5" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">BelajarSiko</span>
                    </div>
                    <p class="text-gray-400 mb-5 max-w-sm">Platform belajar online untuk mengembangkan keterampilan dan
                        karier Anda.</p>
                    <div class="flex items-center gap-4">
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-transform duration-200 hover:scale-110"
                            aria-label="Twitter">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-transform duration-200 hover:scale-110"
                            aria-label="Instagram">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-transform duration-200 hover:scale-110"
                            aria-label="LinkedIn">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </div>
                </div>


                <!-- Quick Links -->
                <div class="lg:col-span-3">
                    <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li><a href="#beranda" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M12 3l9 8.25h-2.25V21h-4.5v-6.75H9.75V21h-4.5v-9.75H3L12 3z" />
                                </svg><span>Beranda</span></a></li>
                        <li><a href="#fitur" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z" />
                                </svg><span>Fitur</span></a></li>
                        <li><a href="#kursus" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M4.5 5.25h15v13.5h-15zM6 6.75h6v10.5H6z" />
                                </svg><span>Kursus</span></a></li>
                        <li><a href="#testimoni"
                                class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 3.75C6.615 3.75 2.25 7.14 2.25 11.25c0 2.22 1.2 4.2 3.105 5.64-.09.93-.405 2.37-1.23 3.63 0 0 2.115-.24 3.705-1.14a12.9 12.9 0 004.17.66c5.385 0 9.75-3.39 9.75-7.5S17.385 3.75 12 3.75z" />
                                </svg><span>Testimoni</span></a></li>
                        <li><a href="#" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M3 19.5l6.75-3 10.5-10.5-3-3L6.75 13.5 3 19.5z" />
                                </svg><span>Blog</span></a></li>
                    </ul>
                </div>


                <!-- Categories -->
                <div class="lg:col-span-3">
                    <h3 class="text-lg font-semibold mb-4">Kategori Kursus</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li><a href="#" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M3.75 6.75h16.5V9H3.75zM3.75 10.5h10.5v1.5H3.75zM3.75 13.5H12V15H3.75z" />
                                </svg><span>Web Development</span></a></li>
                        <li><a href="#" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m1-3l1 3" />
                                </svg><span>Data Science</span></a></li>
                        <li><a href="#" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M9 3h6v4.5H9z" />
                                    <path d="M5.25 9h13.5v12H5.25z" />
                                </svg><span>UI UX Design</span></a></li>
                        <li><a href="#" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                    <path d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                </svg><span>Digital Marketing</span></a></li>
                        <li><a href="#" class="flex items-center gap-2 hover:text-white transition-colors"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5 0l-4.5 9" />
                                </svg><span>Bahasa Pemrograman</span></a></li>
                    </ul>
                </div>


                <!-- Contact -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mt-0.5 text-indigo-400 flex-shrink-0" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2.25c-4.97 0-9 3.6-9 8.04 0 5.73 7.56 10.86 8.27 11.34l.73.47.73-.47c.71-.48 8.27-5.61 8.27-11.34 0-4.44-4.03-8.04-9-8.04z" />
                            </svg><span>Jl. WR. Supratman, Kandang Limun, Kec. Muara Bangka Hulu, Sumatera,
                                Bengkulu</span></li>
                        <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mt-0.5 text-indigo-400 flex-shrink-0" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M1.5 6.75A2.25 2.25 0 013.75 4.5h16.5A2.25 2.25 0 0122.5 6.75V8.1L12 13.5 1.5 8.1V6.75z" />
                                <path
                                    d="M1.5 9.75l7.935 3.967a4.5 4.5 0 003.13 0L20.5 9.75V17.25A2.25 2.25 0 0118.25 19.5H3.75A2.25 2.25 0 011.5 17.25V9.75z" />
                            </svg><span>belajarsiko@gmail.com</span></li>
                        <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mt-0.5 text-indigo-400 flex-shrink-0" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293A13.5 13.5 0 016.963 10.5l1.293-.97c.363-.271.527-.734.417-1.173L7.6 3.102A1.125 1.125 0 006.509 2.25H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg><span>+62 21 1234 5678</span></li>
                    </ul>
                </div>
            </div>


            <div class="mt-12 border-t border-gray-800 pt-8">
                <p class="text-center text-gray-400">&copy; {{ date('Y') }} BelajarSiko. Semua hak cipta
                    dilindungi.</p>
            </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = mobileMenuButton.querySelector('svg:first-child');
            const closeIcon = mobileMenuButton.querySelector('svg:last-child');
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');
            const header = document.getElementById('header');

            function toggleMenu() {
                mobileMenu.classList.toggle('mobile-menu-hidden');
                mobileMenu.classList.toggle('mobile-menu-visible');
                hamburgerIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            }

            mobileMenuButton.addEventListener('click', toggleMenu);
            mobileMenuLinks.forEach(link => link.addEventListener('click', () => {
                if (mobileMenu.classList.contains('mobile-menu-visible')) toggleMenu();
            }));
            document.addEventListener('click', (e) => {
                // Perbaiki logika klik di luar
                const isClickInsideButton = mobileMenuButton.contains(e.target);
                const isClickInsideMenu = mobileMenu.contains(e.target);
                if (!isClickInsideButton && !isClickInsideMenu && mobileMenu.classList.contains(
                        'mobile-menu-visible')) {
                    toggleMenu();
                }
            });

            // Shadow on scroll
            window.addEventListener('scroll', () => {
                if (window.scrollY > 4) {
                    header.classList.add('shadow');
                } else {
                    header.classList.remove('shadow');
                }
            });

            // Close announcement bar
            const announce = document.getElementById('announce');
            const closeAnn = document.getElementById('close-announce');
            if (closeAnn) {
                closeAnn.addEventListener('click', () => announce.classList.add('hidden'));
            }
        });
    </script>

</body>

</html>
