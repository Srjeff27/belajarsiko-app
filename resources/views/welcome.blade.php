<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BelajarSiko - Platform Belajar Online Terdepan</title>

    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%234f46e5'><path stroke-linecap='round' stroke-linejoin='round' d='M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z' /><path stroke-linecap='round' stroke-linejoin='round' d='M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z' /></svg>">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s ease-in-out;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* [Tambah] Kelas untuk animasi show/hide sederhana */
        .mobile-menu-hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            border-top-width: 0;
            /* Sembunyikan border saat tertutup */
            padding-top: 0;
            padding-bottom: 0;
        }

        .mobile-menu-visible {
            max-height: 500px;
            /* Sesuaikan jika menu lebih tinggi */
            transition: max-height 0.4s ease-in;
            border-top-width: 1px;
            /* Tampilkan border saat terbuka */
        }
    </style>
</head>

<body class="antialiased font-sans bg-gray-50 text-gray-800">

    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.905 59.905 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.697 50.697 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">BelajarSiko</span>
                </div>

                <nav class="hidden md:flex space-x-8">
                    <a href="#beranda"
                        class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-300">Beranda</a>
                    <a href="#fitur"
                        class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-300">Fitur</a>
                    <a href="#kursus"
                        class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-300">Kursus</a>
                    <a href="#testimoni"
                        class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-300">Testimoni</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-300">Masuk</a>

                            @if (Route::has('register'))
        <a href="{{ route('register') }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                    Daftar Gratis
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-600 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden mobile-menu-hidden border-gray-200">
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
                            class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center text-gray-600 hover:text-indigo-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main>
        <section id="beranda" class="gradient-bg text-white pt-20 pb-16 md:pt-32 md:pb-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                    <div class="md:w-1/2 mb-10 md:mb-0 text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tighter mb-6">Belajar Lebih Mudah
                            Dengan <span class="text-yellow-300">BelajarSiko</span></h1>
                        <p class="text-xl mb-8 text-indigo-100">Platform belajar online terdepan dengan ribuan materi
                            berkualitas untuk semua tingkat kemampuan. Tingkatkan keterampilan Anda kapan saja, di mana
                            saja.</p>
                        <div
                            class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center md:justify-start">
                            <a href="{{ Route::has('register') ? route('register') : '#' }}"
                                class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 transform hover:scale-105">Mulai
                                Belajar Gratis</a>
                            <a href="#kursus"
                                class="border-2 border-white text-white hover:bg-white/10 px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 transform hover:scale-105">Lihat
                                Kursus</a>
                        </div>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="Siswa sedang belajar online"
                            class="rounded-xl shadow-2xl w-full max-w-lg object-cover">
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-20 lg:py-24 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Mengapa Memilih BelajarSiko?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Platform kami dirancang untuk memberikan
                        pengalaman belajar terbaik dengan fitur-fitur unggulan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Instruktur Berpengalaman</h3>
                        <p class="text-gray-600">Belajar dari para ahli di bidangnya dengan pengalaman mengajar yang
                            telah teruji.</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Akses Seumur Hidup</h3>
                        <p class="text-gray-600">Setelah membeli kursus, Anda dapat mengakses materi selamanya tanpa
                            batas waktu.</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15m-3.15 0v-1.5" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Pembelajaran Interaktif</h3>
                        <p class="text-gray-600">Metode pembelajaran yang menarik dengan kuis, tugas, dan forum
                            diskusi.</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.602-.36-3.112-.984-4.524A11.959 11.959 0 0112 2.714z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Sertifikat Penyelesaian</h3>
                        <p class="text-gray-600">Dapatkan sertifikat resmi setelah menyelesaikan kursus untuk
                            meningkatkan kredibilitas Anda.</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Konten Terupdate</h3>
                        <p class="text-gray-600">Materi kursus selalu diperbarui sesuai perkembangan terbaru di
                            industri.</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg card-hover">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.001M18 18.72a9.094 9.094 0 01-3.741-.479 3 3 0 01-4.682-2.72m-.94 3.198l-.001.001M12 12a3 3 0 11-6 0 3 3 0 016 0zM12 12a3 3 0 00-3 2.685 3 3 0 000 5.63m3-8.315a3 3 0 01-3 2.685 3 3 0 010 5.63m3-8.315a3 3 0 013 2.685 3 3 0 010 5.63m3-8.315a3 3 0 00-3 2.685 3 3 0 000 5.63" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Komunitas Belajar</h3>
                        <p class="text-gray-600">Bergabung dengan komunitas pembelajar untuk berdiskusi dan
                            berkolaborasi.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kursus" class="py-20 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Kursus Populer</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Jelajahi berbagai kursus berkualitas tinggi dari
                        instruktur terbaik di industri.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover">
                        <img class="w-full h-48 object-cover"
                            src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="Web Development Course">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold">Web Development Mastery</h3>
                                <span
                                    class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Populer</span>
                            </div>
                            <p class="text-gray-600 mb-4">Pelajari pengembangan web modern dari dasar hingga mahir
                                dengan teknologi terbaru.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-gray-600">4.9 (1.2k)</span>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">Rp 299.000</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover">
                        <img class="w-full h-48 object-cover"
                            src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="Data Science Course">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold">Data Science Fundamentals</h3>
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Baru</span>
                            </div>
                            <p class="text-gray-600 mb-4">Kuasai dasar-dasar ilmu data dengan Python, statistik, dan
                                visualisasi data.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-gray-600">4.8 (890)</span>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">Rp 399.000</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover">
                        <img class="w-full h-48 object-cover"
                            src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                            alt="UI/UX Design Course">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold">UI/UX Design Principles</h3>
                                <span
                                    class="bg-pink-100 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Terlaris</span>
                            </div>
                            <p class="text-gray-600 mb-4">Pelajari prinsip desain antarmuka dan pengalaman pengguna
                                untuk aplikasi modern.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-gray-600">4.9 (1.5k)</span>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">Rp 249.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="#"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-300">
                        Lihat Semua Kursus
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section id="testimoni" class="py-20 lg:py-24 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Apa Kata Mereka?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Dengarkan pengalaman langsung dari para siswa
                        yang telah bergabung dengan BelajarSiko.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <img class="w-12 h-12 rounded-full object-cover mr-4"
                                src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=48&h=48&q=80"
                                alt="Avatar Pengguna 1">
                            <div>
                                <h4 class="font-semibold">Ahmad Rizki</h4>
                                <p class="text-gray-500 text-sm">Web Developer</p>
                            </div>
                        </div>
                        <div class="flex mb-2">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 italic">"Kursus web development di BelajarSiko sangat lengkap dan
                            terstruktur. Saya dari pemula sekarang sudah bisa membuat website profesional. Terima
                            kasih!"</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <img class="w-12 h-12 rounded-full object-cover mr-4"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=48&h=48&q=80"
                                alt="Avatar Pengguna 2">
                            <div>
                                <h4 class="font-semibold">Sari Dewi</h4>
                                <p class="text-gray-500 text-sm">UI/UX Designer</p>
                            </div>
                        </div>
                        <div class="flex mb-2">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 italic">"Sebagai seorang pemula di bidang desain, kursus UI/UX di
                            BelajarSiko sangat membantu. Materinya mudah dipahami dan instrukturnya sangat
                            berpengalaman."</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <img class="w-12 h-12 rounded-full object-cover mr-4"
                                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=48&h=48&q=80"
                                alt="Avatar Pengguna 3">
                            <div>
                                <h4 class="font-semibold">Budi Pratama</h4>
                                <p class="text-gray-500 text-sm">Data Analyst</p>
                            </div>
                        </div>
                        <div class="flex mb-2">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 italic">"Kursus data science di BelajarSiko sangat praktis dan
                            aplikatif. Saya langsung bisa menerapkan ilmu yang didapat di pekerjaan. Sangat
                            recommended!"</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 lg:py-24 gradient-bg text-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-6">Siap Memulai Perjalanan Belajar Anda?
                </h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto text-indigo-100">Bergabunglah dengan ribuan siswa lainnya dan
                    raih keterampilan baru yang akan mengubah karir Anda.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}"
                        class="bg-white text-indigo-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105">Daftar
                        Sekarang</a>
                    <a href="#kursus"
                        class="border-2 border-white text-white hover:bg-white/10 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105">Lihat
                        Kursus Gratis</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white pt-16 pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.905 59.905 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.697 50.697 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">BelajarSiko</span>
                    </div>
                    <p class="text-gray-400 mb-4">Platform belajar online terdepan untuk mengembangkan keterampilan
                        dan karir Anda.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="#beranda"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Beranda
                            </a></li>
                        <li><a href="#fitur"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.998 15.998 0 011.622-3.388m0 0c.058 1.17.22 2.3.464 3.388m-1.622-3.388a15.998 15.998 0 013.388 1.62m0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.998 15.998 0 011.622-3.388" />
                                </svg>
                                Fitur
                            </a></li>
                        <li><a href="#kursus"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                                </svg>
                                Kursus
                            </a></li>
                        <li><a href="#testimoni"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25S3.75 16.556 3.75 12 7.61 3.75 12.375 3.75 21 7.444 21 12z" />
                                </svg>
                                Testimoni
                            </a></li>
                        <li><a href="#"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                                Blog
                            </a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Kategori Kursus</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                Web Development
                            </a></li>
                        <li><a href="#"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m1-3l1 3m0 0l.5 1.5m-.5-1.5l-.5 1.5m0 0l.5 1.5m0 0l.5 1.5m7.5-6l-1-3m1 3l1-3m0 0l.5-1.5m-.5 1.5l-.5-1.5m0 0l.5-1.5m0 0l.5-1.5" />
                                </svg>
                                Data Science
                            </a></li>
                        <li><a href="#"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .828.201 1.62.568 2.33l3.5 7.017M14.25 3.104c.251.023.501.05.75.082M14.25 3.104a24.301 24.301 0 00-4.5 0m0 0v5.714c0 .828-.201 1.62-.568 2.33l-3.5 7.017M14.25 16.172l-3.5-7.017" />
                                </svg>
                                UI/UX Design
                            </a></li>
                        <li><a href="#"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                </svg>
                                Digital Marketing
                            </a></li>
                        <li><a href="#"
                                class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5 0l-4.5 9" />
                                </svg>
                                Bahasa Pemrograman
                            </a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2 text-indigo-400 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span class="text-gray-400">Jl. WR. Supratman, Kandang Limun, Kec. Muara Bangka Hulu,
                                Sumatera, Bengkulu</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2 text-indigo-400 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <span class="text-gray-400">belajarsiko@gmail.com</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2 text-indigo-400 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.822-1.49-5.02-3.688-6.509-6.509l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <span class="text-gray-400">+62 21 1234 5678</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} BelajarSiko. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = mobileMenuButton.querySelector('svg:first-child'); // Ikon hamburger
            const closeIcon = mobileMenuButton.querySelector('svg:last-child'); // Ikon X
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link'); // Semua link di menu mobile

            // Fungsi untuk toggle menu
            function toggleMenu() {
                mobileMenu.classList.toggle('mobile-menu-hidden');
                mobileMenu.classList.toggle('mobile-menu-visible');
                hamburgerIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            }

            // Event listener untuk tombol hamburger
            mobileMenuButton.addEventListener('click', toggleMenu);

            // Event listener untuk menutup menu saat link diklik (untuk navigasi # anchor)
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (mobileMenu.classList.contains('mobile-menu-visible')) {
                        toggleMenu();
                    }
                });
            });

            // (Opsional) Menutup menu saat klik di luar area menu
            document.addEventListener('click', function(event) {
                const isClickInsideHeader = mobileMenuButton.contains(event.target);
                const isClickInsideMenu = mobileMenu.contains(event.target);

                if (!isClickInsideHeader && !isClickInsideMenu && mobileMenu.classList.contains(
                        'mobile-menu-visible')) {
                    toggleMenu();
                }
            });
        });
    </script>

</body>

</html>
