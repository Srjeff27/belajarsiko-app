<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sertifikat Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-0 text-gray-900 dark:text-gray-100">

                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 px-4 sm:px-0">
                    <x-heroicon-o-academic-cap class="w-7 h-7 text-indigo-500"/>
                    Koleksi Sertifikat Anda
                </h3>

                @if(isset($certificates) && $certificates->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 sm:px-0">

                        @foreach($certificates as $certificate)
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col sm:flex-row items-center transition-shadow duration-300 hover:shadow-xl border dark:border-gray-200 dark:border-gray-700">

                                <div class="w-full sm:w-1/3 flex-shrink-0">
                                     {{-- Link ke kursus jika perlu --}}
                                    <a href="{{ route('courses.show', $certificate->course) }}" wire:navigate>
                                        <img class="w-full h-32 sm:h-full object-cover"
                                             src="{{ $certificate->course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80' }}"
                                             alt="{{ $certificate->course->title }}">
                                    </a>
                                </div>

                                <div class="p-5 flex-grow w-full">
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                         <a href="{{ route('courses.show', $certificate->course) }}" wire:navigate class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                            {{ $certificate->course->title }}
                                         </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                                        Diperoleh pada: {{ $certificate->generated_at->isoFormat('D MMMM YYYY') }}
                                        {{-- Tampilkan kode unik jika ada --}}
                                        {{-- @if($certificate->unique_code)
                                            <span class="block mt-1">Kode: {{ $certificate->unique_code }}</span>
                                        @endif --}}
                                    </p>

                                    <a href="{{ route('certificate.download', $certificate->course) }}" {{-- Pastikan route ini benar --}}
                                       class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                        <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2 -ml-1"/>
                                        Unduh Sertifikat (PDF)
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                     {{-- Pagination Styling --}}
                     @if ($certificates instanceof \Illuminate\Pagination\LengthAwarePaginator && $certificates->hasPages())
                        <div class="mt-8 px-4 sm:px-0">
                            {{ $certificates->links() }}
                        </div>
                     @endif

                @else
                    {{-- Empty State --}}
                    <div class="text-center bg-white dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700 p-10 rounded-xl mx-4 sm:mx-0">
                        <x-heroicon-o-document-minus class="w-16 h-16 text-indigo-400 mx-auto mb-4"/>
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Sertifikat</h4>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-6">
                            Selesaikan kursus hingga 100% untuk mendapatkan sertifikat kelulusan Anda. Terus semangat belajar!
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
</x-app-layout>