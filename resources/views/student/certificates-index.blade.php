<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sertifikat Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0 text-gray-900 dark:text-gray-100 space-y-12"> {{-- Tambah padding & space-y --}}

                {{-- Bagian 1: Siap Diajukan (Eligible) --}}
                @if(isset($eligibleCourses) && $eligibleCourses->count())
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <x-heroicon-o-check-circle class="w-7 h-7 text-green-500"/>
                            Siap Diajukan (Selesai 100%)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($eligibleCourses as $course)
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 transition-shadow hover:shadow-xl duration-300">
                                    {{-- Info Kursus --}}
                                    <div class="flex items-center gap-4 w-full sm:w-auto">
                                        <img class="w-16 h-16 object-cover rounded-lg flex-shrink-0" src="{{ $course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=160&q=80' }}" alt="{{ $course->title }}">
                                        <div class="flex-grow">
                                            <div class="font-semibold text-gray-900 dark:text-white">{{ $course->title }}</div>
                                            <div class="text-xs text-green-600 dark:text-green-400 font-medium">Progres: 100% Selesai</div>
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Aksi --}}
                                    <div class="w-full sm:w-auto flex-shrink-0">
                                        @php $isRequested = isset($requestedCourseIds) && $requestedCourseIds->contains($course->id); @endphp
                                        @if($isRequested)
                                            <button class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                                <x-heroicon-o-clock class="w-5 h-5 mr-1.5"/> Menunggu Verifikasi
                                            </button>
                                        @else
                                            <form method="POST" action="{{ route('certificate.request', $course) }}">
                                                @csrf
                                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                                    <x-heroicon-o-paper-airplane class="w-5 h-5 mr-1.5 -rotate-45"/> Ajukan Sertifikat
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Bagian 2: Koleksi Sertifikat (Sudah Jadi) --}}
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <x-heroicon-o-academic-cap class="w-7 h-7 text-indigo-500"/>
                        Koleksi Sertifikat Saya
                    </h3>

                    @if(isset($certificates) && $certificates->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($certificates as $certificate)
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col sm:flex-row items-center transition-shadow duration-300 hover:shadow-xl border dark:border-gray-200 dark:border-gray-700">
                                    
                                    {{-- Thumbnail --}}
                                    <div class="w-full sm:w-1/3 flex-shrink-0">
                                       <a href="{{ route('courses.show', $certificate->course) }}" wire:navigate>
                                            <img class="w-full h-32 sm:h-full object-cover"
                                                 src="{{ $certificate->course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80' }}"
                                                 alt="{{ $certificate->course->title }}">
                                        </a>
                                    </div>

                                    {{-- Info Sertifikat --}}
                                    <div class="p-5 flex-grow w-full">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                             <a href="{{ route('courses.show', $certificate->course) }}" wire:navigate class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                                {{ $certificate->course->title }}
                                             </a>
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            Diperoleh pada: {{ $certificate->generated_at->isoFormat('D MMMM YYYY') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            Kode: <span class="font-mono">{{ $certificate->unique_code }}</span>
                                        </p>
                                        @php
                                            $genAt = $certificate->generated_at ?? now();
                                            $seq = str_pad((string) ($certificate->id ?? 0), 3, '0', STR_PAD_LEFT);
                                            $courseSeg = str_replace(['/', '\\'], '-', $certificate->course->title ?? 'Kelas');
                                            $formalNumber = ($certificate->formal_number ?? null) ?: ($seq . '/SK/BelajarSiko/' . $courseSeg . '/' . $genAt->format('Y'));
                                        @endphp
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                                            Nomor: <span class="font-mono">{{ $formalNumber }}</span>
                                        </p>

                                        {{-- Tombol Unduh --}}
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('certificate.download', $certificate->course) }}" {{-- Pastikan route ini benar --}}
                                               class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                                <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2 -ml-1"/>
                                                Unduh PDF
                                            </a>
                                            @if($certificate->google_drive_link)
                                                <a href="{{ $certificate->google_drive_link }}" target="_blank" rel="noopener"
                                                   class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                                    <x-heroicon-o-link class="w-5 h-5 mr-2 -ml-1"/> 
                                                    Lihat di Drive
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                         {{-- Pagination Styling --}}
                         @if ($certificates instanceof \Illuminate\Pagination\LengthAwarePaginator && $certificates->hasPages())
                            <div class="mt-8">
                                {{ $certificates->links() }}
                            </div>
                         @endif

                    @elseif(!isset($eligibleCourses) || $eligibleCourses->count() === 0)
                        {{-- Empty State (HANYA tampil jika kedua bagian kosong) --}}
                        <div class="text-center bg-white dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700 p-10 rounded-xl">
                            <x-heroicon-o-document-minus class="w-16 h-16 text-indigo-400 mx-auto mb-4"/>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Sertifikat</h4>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-6">
                                Selesaikan kursus hingga 100% untuk bisa mengajukan sertifikat. Terus semangat belajar!
                            </p>
                            <a href="{{ route('student.courses') }}" wire:navigate class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                <x-heroicon-o-book-open class="w-5 h-5 mr-2"/>
                                Lihat Kelas Saya
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
