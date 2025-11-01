<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ isset($isExplore) && $isExplore ? __('Jelajahi Kelas') : __('Kelas Saya') }}
            </h2>
            @if (!isset($isExplore) || !$isExplore)
                <a href="{{ route('student.courses', ['explore' => 1]) }}" wire:navigate
                    class="inline-flex lg:hidden items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                    <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                    Ambil Kelas
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-0 text-gray-900 dark:text-gray-100">

                <div class="flex items-center justify-between px-4 sm:px-0 mb-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-heroicon-o-squares-2x2 class="w-7 h-7 text-indigo-500" />
                        {{ isset($isExplore) && $isExplore ? 'Semua Kelas Tersedia' : 'Kelas Saya' }}
                    </h3>
                    @if (!isset($isExplore) || !$isExplore)
                        <a href="{{ route('student.courses', ['explore' => 1]) }}" wire:navigate
                            class="hidden lg:inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                            <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                            Ambil Kelas
                        </a>
                    @endif
                </div>

                {{-- Filter Kategori --}}
                @if (isset($isExplore) && $isExplore && isset($categories))
                    <div class="px-4 sm:px-0 mb-6">
                        <div class="flex flex-wrap items-center gap-2">
                            @php $isAll = empty($activeCategory); @endphp
                            <a href="{{ route('student.courses') }}" @class([
                                'inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border transition',
                                'bg-indigo-600 text-white border-indigo-600' => $isAll,
                                'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isAll,
                            ])>
                                Semua
                            </a>
                            @foreach ($categories as $cat)
                                @php $active = isset($activeCategory) && $activeCategory && $activeCategory->id === $cat->id; @endphp
                                <a href="{{ route('student.courses', ['category' => $cat->slug]) }}"
                                    @class([
                                        'inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium border transition',
                                        'bg-indigo-600 text-white border-indigo-600' => $active,
                                        'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' => !$active,
                                    ])>
                                    <x-heroicon-s-tag class="w-4 h-4" />
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (isset($courses) && $courses->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                        {{-- Ubah padding --}}

                        @foreach ($courses as $course)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-1 hover:shadow-xl border dark:border-gray-700 duration-300 ease-in-out">
                                {{-- Tambah duration --}}

                                <a href="{{ route('courses.show', $course) }}" wire:navigate>
                                    <img class="w-full h-48 object-cover transition-opacity hover:opacity-90 duration-300"
                                        {{-- Tambah duration --}}
                                        src="{{ $course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                        alt="{{ $course->title }}">
                                </a>

                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                        <a href="{{ route('courses.show', $course) }}" wire:navigate
                                            class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">{{ $course->title }}</a>
                                        {{-- Tambah duration --}}
                                    </h3>
                                    @if ($course->category?->name)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 text-[10px] font-medium mb-2">
                                            <x-heroicon-s-tag class="w-3 h-3" /> {{ $course->category->name }}
                                        </span>
                                    @endif
                                    {{-- Nama Mentor --}}
                                    @if ($course->mentor_name)
                                        <p
                                            class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mb-2">
                                            <x-heroicon-s-user-circle class="w-3.5 h-3.5" /> {{-- Tambah ikon --}}
                                            Oleh: {{ $course->mentor_name }}
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 flex-grow">
                                        {{ $course->description }}</p>

                                    <div class="flex flex-wrap items-center gap-2 text-xs mb-5">
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                                            <x-heroicon-s-book-open class="w-3.5 h-3.5" />
                                            {{ $course->lessons_count ?? 0 }} Materi
                                        </span>
                                        @if ($course->is_premium)
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 font-medium">
                                                <x-heroicon-s-star class="w-3.5 h-3.5" />
                                                Premium (Rp {{ number_format($course->price, 0, ',', '.') }})
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 font-medium">
                                                <x-heroicon-s-check-badge class="w-3.5 h-3.5" />
                                                Gratis
                                            </span>
                                        @endif
                                    </div>

                                    <div
                                        class="mt-auto pt-4 border-t border-gray-200 dark:border-gray-700 flex items-center gap-3">
                                        @php
                                            $isEnrolled = $enrolledCourseIds->contains($course->id);
                                        @endphp

                                        @if ($isEnrolled)
                                            <a href="{{ route('courses.show', $course) }}" wire:navigate
                                                class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                                <x-heroicon-o-play class="w-5 h-5 mr-2 -ml-1" />
                                                Lanjutkan
                                            </a>
                                        @elseif($course->is_premium)
                                            <a href="{{ route('checkout.course', $course) }}" wire:navigate
                                                class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                                <x-heroicon-o-shopping-cart class="w-5 h-5 mr-2 -ml-1" />
                                                Beli Kelas
                                            </a>
                                        @else
                                            {{-- Gratis & Belum Enroll --}}
                                            <form method="POST" action="{{ route('courses.enroll', $course) }}"
                                                class="flex-1">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                                    <x-heroicon-o-plus-circle class="w-5 h-5 mr-2 -ml-1" />
                                                    Ambil Gratis
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('courses.show', $course) }}" wire:navigate
                                            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300"
                                            title="Lihat Detail Kelas">
                                            <x-heroicon-o-eye class="w-5 h-5" />
                                            <span class="sr-only sm:not-sr-only sm:ml-1.5">Detail</span>
                                            {{-- Ubah ml-1 --}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination Styling --}}
                    @if ($courses instanceof \Illuminate\Pagination\LengthAwarePaginator && $courses->hasPages())
                        <div class="mt-8 px-4 sm:px-0"> {{-- Ubah padding --}}
                            {{ $courses->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center bg-white dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700 p-10 rounded-xl mx-4 sm:mx-0">
                        <x-heroicon-o-squares-plus class="w-16 h-16 text-indigo-400 mx-auto mb-4" />
                        @if(isset($isExplore) && $isExplore)
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Kelas Sudah Diambil Semua</h4>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-6">
                                Mantap! Kamu sudah mengambil semua kelas yang tersedia saat ini.
                            </p>
                            <a href="{{ route('student.courses') }}" wire:navigate
                               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700">
                                <x-heroicon-s-arrow-left class="w-5 h-5 mr-2" />
                                Kembali ke Kelas Saya
                            </a>
                        @else
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Kelas Diambil</h4>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-6">
                                Kamu belum mengambil kelas apa pun. Ayo jelajahi dan ambil kelas pertamamu.
                            </p>
                            <a href="{{ route('student.courses', ['explore' => 1]) }}" wire:navigate
                               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700">
                                <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                                Ambil Kelas
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
