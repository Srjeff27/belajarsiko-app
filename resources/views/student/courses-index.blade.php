<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jelajahi Kelas') }} </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-7 h-7 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                        Semua Kelas Tersedia
                    </h3>

                    @if(isset($courses) && $courses->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                            @foreach($courses as $course)
                                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-1 hover:shadow-2xl border dark:border-gray-700">

                                    <a href="{{ route('courses.show', $course) }}" wire:navigate>
                                        <img class="w-full h-48 object-cover transition-opacity hover:opacity-90"
                                             src="{{ $course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                             alt="{{ $course->title }}">
                                    </a>

                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                             <a href="{{ route('courses.show', $course) }}" wire:navigate class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $course->title }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 flex-grow">{{ $course->description }}</p>

                                        <div class="flex items-center gap-3 text-xs mb-4">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                                                <x-heroicon-o-book-open class="w-3.5 h-3.5"/>
                                                {{ $course->lessons_count ?? 0 }} Materi
                                            </span>
                                            @if($course->is_premium)
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-300 font-medium">
                                                    <x-heroicon-s-star class="w-3.5 h-3.5"/>
                                                    Premium
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 font-medium">
                                                     <x-heroicon-s-check-badge class="w-3.5 h-3.5"/>
                                                    Gratis
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-auto pt-4 border-t border-gray-200 dark:border-gray-700 flex items-center gap-3">
                                            @php
                                                // Status enroll sudah dihitung di controller sebagai $course->is_enrolled
                                                $isEnrolled = $course->is_enrolled ?? false; 
                                            @endphp

                                            @if($isEnrolled)
                                                <a href="{{ route('courses.show', $course) }}" wire:navigate
                                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                    <x-heroicon-o-play class="w-5 h-5 mr-2 -ml-1"/>
                                                    Lanjutkan
                                                </a>
                                            @elseif($course->is_premium)
                                                <a href="{{ route('checkout.course', $course) }}" wire:navigate
                                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                    <x-heroicon-o-shopping-cart class="w-5 h-5 mr-2 -ml-1"/>
                                                    Beli Kelas
                                                </a>
                                            @else {{-- Gratis & Belum Enroll --}}
                                                <form method="POST" action="{{ route('courses.enroll', $course) }}" class="flex-1">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                        <x-heroicon-o-plus-circle class="w-5 h-5 mr-2 -ml-1"/>
                                                        Enroll Gratis
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            {{-- Tombol Detail selalu ada --}}
                                            <a href="{{ route('courses.show', $course) }}" wire:navigate
                                               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300"
                                               title="Lihat Detail Kelas">
                                                <x-heroicon-o-eye class="w-5 h-5"/>
                                                <span class="sr-only">Detail</span> {{-- Hanya ikon di layar kecil --}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                         {{-- <div class="mt-8">
                            {{ $courses->links() }}
                        </div> --}}

                    @else
                        <div class="text-center bg-gray-50 dark:bg-gray-900 p-10 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                           <x-heroicon-o-squares-plus class="w-16 h-16 text-indigo-400 mx-auto mb-4"/>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Kelas Tersedia</h4>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                                Saat ini belum ada kelas yang dipublikasikan. Silakan cek kembali nanti!
                            </p>
                            {{-- Mungkin link ke homepage atau kontak admin --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
