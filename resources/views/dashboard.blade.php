<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Hapus Card Pembungkus Utama Agar Konten Langsung di Latar Belakang Layout --}}
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> --}}
                <div class="p-0 md:p-0 text-gray-900 dark:text-gray-100 space-y-8 md:space-y-12"> {{-- Hapus padding awal, tambah space-y --}}

                    {{-- Bagian Notifikasi --}}
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <x-heroicon-o-bell class="w-7 h-7 text-indigo-500"/>
                            Notifikasi Terbaru
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            {{-- Kartu Penilaian Terbaru --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-5 flex flex-col">
                                <h4 class="font-semibold mb-4 text-gray-800 dark:text-gray-200 flex items-center gap-2 text-base border-b dark:border-gray-700 pb-2">
                                    <x-heroicon-o-check-badge class="w-5 h-5 text-green-500"/> Penilaian Terbaru
                                </h4>
                                @if(isset($recentGraded) && $recentGraded->count())
                                    <ul class="space-y-3 text-sm flex-grow">
                                        @foreach($recentGraded as $s)
                                            <li>
                                                {{-- Link ke tugas spesifik di halaman course show --}}
                                                <a href="{{ route('courses.show', $s->assignment->lesson->course) }}#assignment-{{ $s->assignment->id }}" wire:navigate
                                                   class="flex justify-between items-center gap-3 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                    <span class="truncate text-gray-700 dark:text-gray-300">{{ $s->assignment->lesson->course->title }} — {{ $s->assignment->title }}</span>
                                                    <span class="font-bold text-green-600 dark:text-green-400 flex-shrink-0">{{ $s->grade }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                     {{-- Tombol Lihat Semua (Opsional) --}}
                                     <div class="mt-4 text-center">
                                         <a href="{{ route('student.assignments') }}" wire:navigate class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Lihat Semua Tugas</a>
                                     </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4 flex-grow flex items-center justify-center">
                                        <x-heroicon-o-inbox class="w-5 h-5 mr-1"/> Belum ada penilaian terbaru.
                                    </p>
                                @endif
                            </div>

                            {{-- Kartu Tugas Baru --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-5 flex flex-col">
                                <h4 class="font-semibold mb-4 text-gray-800 dark:text-gray-200 flex items-center gap-2 text-base border-b dark:border-gray-700 pb-2">
                                    <x-heroicon-o-clipboard-document-list class="w-5 h-5 text-blue-500"/> Tugas Baru (7 hari)
                                </h4>
                                @if(isset($newAssignments) && $newAssignments->count())
                                    <ul class="space-y-3 text-sm flex-grow">
                                        @foreach($newAssignments as $a)
                                             <li>
                                                 {{-- Link ke tugas spesifik --}}
                                                <a href="{{ route('courses.show', $a->lesson->course) }}#assignment-{{ $a->id }}" wire:navigate
                                                   class="block truncate p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                   {{ $a->lesson->course->title }} — {{ $a->title }}
                                                </a>
                                             </li>
                                        @endforeach
                                    </ul>
                                     <div class="mt-4 text-center">
                                         <a href="{{ route('student.assignments') }}" wire:navigate class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Lihat Semua Tugas</a>
                                     </div>
                                @else
                                     <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4 flex-grow flex items-center justify-center">
                                         <x-heroicon-o-inbox class="w-5 h-5 mr-1"/> Tidak ada tugas baru minggu ini.
                                    </p>
                                @endif
                            </div>

                             {{-- Kartu Materi Baru --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-5 flex flex-col">
                                <h4 class="font-semibold mb-4 text-gray-800 dark:text-gray-200 flex items-center gap-2 text-base border-b dark:border-gray-700 pb-2">
                                    <x-heroicon-o-list-bullet class="w-5 h-5 text-purple-500"/> Materi Baru (7 hari)
                                </h4>
                                @if(isset($newLessons) && $newLessons->count())
                                    <ul class="space-y-3 text-sm flex-grow">
                                        @foreach($newLessons as $l)
                                             <li>
                                                 {{-- Link ke materi spesifik (jika ada route-nya) --}}
                                                <a href="{{ route('courses.show', $l->course) }}#lesson-{{ $l->id }}" {{-- Asumsi ada ID di elemen materi --}}
                                                   wire:navigate
                                                   class="block truncate p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                    {{ $l->course->title }} — {{ $l->title }}
                                                </a>
                                             </li>
                                        @endforeach
                                    </ul>
                                     <div class="mt-4 text-center">
                                         <a href="{{ route('student.courses') }}" wire:navigate class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Lihat Semua Kelas</a>
                                     </div>
                                @else
                                     <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4 flex-grow flex items-center justify-center">
                                        <x-heroicon-o-inbox class="w-5 h-5 mr-1"/> Tidak ada materi baru minggu ini.
                                     </p>
                                @endif
                            </div>
                        </div>
                    </div>

                     {{-- Bagian Kelas Saya --}}
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <x-heroicon-o-academic-cap class="w-7 h-7 text-indigo-500"/>
                            Kelas Saya
                        </h3>

                        @if(isset($enrollments) && $enrollments->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                                @foreach($enrollments as $enroll)
                                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-1 hover:shadow-2xl border dark:border-gray-700"> {{-- Tambah Border --}}

                                        <a href="{{ route('courses.show', $enroll->course) }}" wire:navigate> {{-- Tambah wire:navigate --}}
                                            <img class="w-full h-48 object-cover"
                                                 src="{{ $enroll->course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                                 alt="{{ $enroll->course->title }}">
                                        </a>

                                        <div class="p-5 flex flex-col flex-grow">
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 truncate">{{ $enroll->course->title }}</h4>

                                            <div class="mb-4">
                                                @php $courseProgress = $progress[$enroll->course->id] ?? 0; @endphp
                                                <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                    <span>Progres</span>
                                                    <span class="font-semibold">{{ $courseProgress }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                    <div class="bg-indigo-600 dark:bg-indigo-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $courseProgress }}%"></div>
                                                </div>
                                            </div>

                                            <div class="mt-auto flex flex-col sm:flex-row gap-3">
                                                <a href="{{ route('courses.show', $enroll->course) }}" wire:navigate {{-- Tambah wire:navigate --}}
                                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                    <x-heroicon-o-play class="w-5 h-5 mr-2"/>
                                                    Lanjutkan Belajar
                                                </a>

                                                @if($courseProgress === 100)
                                                    <a href="{{ route('certificate.download', $enroll->course) }}"
                                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                        <x-heroicon-o-academic-cap class="w-5 h-5 mr-2"/>
                                                        Unduh Sertifikat
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            {{-- Empty State Kelas Saya --}}
                            <div class="text-center bg-white dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700 p-10 rounded-xl">
                                <x-heroicon-o-book-open class="w-16 h-16 text-indigo-400 mx-auto mb-4"/>
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Anda Belum Memiliki Kelas</h4>
                                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                                    Sepertinya Anda belum mendaftar di kelas manapun. Ayo mulai perjalanan belajar Anda sekarang!
                                </p>
                                <a href="{{ route('student.courses') }}" wire:navigate {{-- Arahkan ke halaman daftar kelas --}}
                                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                    <x-heroicon-o-magnifying-glass class="w-5 h-5 mr-2"/>
                                    Jelajahi Kursus
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            {{-- </div> --}} {{-- Hapus tag penutup card pembungkus utama --}}
        </div>
    </div>
</x-app-layout>