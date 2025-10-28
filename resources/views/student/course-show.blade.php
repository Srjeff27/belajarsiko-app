<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate">
            {{ $course->title }}
        </h2>
    </x-slot>

    {{-- Alpine.js State --}}
    <div x-data="{ 
            activeLessonId: @js($course->lessons->first()?->id), 
            assignmentOpen: {} 
        }" 
         class="py-8 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8 space-y-6 lg:space-y-0">

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
                                <x-heroicon-o-information-circle class="w-6 h-6 text-indigo-500"/>
                                Deskripsi Kursus
                            </h3>
                            <p class="text-sm text-gray-700 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">
                                {{ $course->description }}
                            </p>
                            
                            @if(!$isEnrolled)
                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Daftar Kelas Ini</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Dapatkan akses penuh ke semua materi dan tugas.</p>
                                @if($course->is_premium)
                                    <a href="{{ route('checkout.course', $course) }}" 
                                       class="inline-flex items-center justify-center w-full px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                        <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        </svg>
                                        Beli Kelas (Rp {{ number_format($course->price, 0, ',', '.') }})
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                        @csrf
                                        <button type="submit"
                                           class="inline-flex items-center justify-center w-full px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300">
                                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                            Ambil Kelas
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                        <div class="p-6">
                             <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                                <x-heroicon-o-list-bullet class="w-6 h-6 text-indigo-500"/>
                                Materi Pelajaran
                            </h3>
                            <div class="space-y-2">
                                @forelse($course->lessons as $lesson)
                                    @php
                                        // Cek apakah lesson ini sudah diselesaikan oleh user
                                        $isCompleted = $completedLessons->contains($lesson->id); 
                                    @endphp
                                    <button 
                                        @click="activeLessonId = {{ $lesson->id }}"
                                        :class="{ 
                                            'bg-indigo-100 dark:bg-indigo-900 border-l-4 border-indigo-500': activeLessonId === {{ $lesson->id }}, 
                                            'hover:bg-gray-100 dark:hover:bg-gray-700': activeLessonId !== {{ $lesson->id }} 
                                        }"
                                        class="w-full flex items-center justify-between text-left p-3 rounded-md transition-colors duration-200 border border-transparent dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            @if($lesson->lesson_type === 'video')
                                                <x-heroicon-o-play-circle class="w-5 h-5 text-gray-500 dark:text-gray-400 flex-shrink-0"/>
                                            @else
                                                <x-heroicon-o-document-text class="w-5 h-5 text-gray-500 dark:text-gray-400 flex-shrink-0"/>
                                            @endif
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $lesson->title }}</span>
                                        </div>
                                        @if($isCompleted)
                                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" title="Selesai"/>
                                        @endif
                                    </button>
                                @empty
                                 <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada materi ditambahkan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    @forelse($course->lessons as $lesson)
                        {{-- Tampilkan hanya jika lesson ini aktif --}}
                        <div x-show="activeLessonId === {{ $lesson->id }}" x-transition x-cloak
                             class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700 gap-3">
                                    <div class="flex items-center gap-2">
                                         @if($lesson->lesson_type === 'video')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                <x-heroicon-s-video-camera class="w-4 h-4 mr-1"/> VIDEO
                                            </span>
                                        @else
                                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                                <x-heroicon-s-document class="w-4 h-4 mr-1"/> EBOOK
                                            </span>
                                        @endif
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $lesson->title }}</h3>
                                    </div>
                                    
                                    {{-- Tombol Tandai Selesai hanya jika user terdaftar --}}
                                    @if($isEnrolled)
                                        @php $isCompleted = $completedLessons->contains($lesson->id); @endphp
                                        <form method="POST" action="{{ route('lessons.complete', $lesson) }}">
                                            @csrf
                                            <button 
                                                type="submit"
                                                @disabled($isCompleted)
                                                @class([
                                                    'inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
                                                    'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500' => !$isCompleted,
                                                    'bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-400 cursor-not-allowed' => $isCompleted,
                                                ])>
                                                
                                                @if($isCompleted)
                                                    <x-heroicon-s-check-circle class="w-5 h-5 mr-2 -ml-1"/> Selesai Ditandai
                                                @else
                                                    <x-heroicon-o-check-circle class="w-5 h-5 mr-2 -ml-1"/> Tandai Selesai
                                                @endif
                                            </button>
                                        </form>
                                     @endif
                                </div>

                                <div class="aspect-video mb-4 bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden border dark:border-gray-700">
                                    @if($lesson->lesson_type === 'video')
                                        {{-- Pastikan URL Youtube adalah URL embed --}}
                                        @php
                                            $embedUrl = str_replace('watch?v=', 'embed/', $lesson->content_url);
                                            // Tambahkan parameter untuk kontrol yang lebih baik (opsional)
                                            $embedUrl .= '?rel=0&modestbranding=1';
                                        @endphp
                                        <iframe src="{{ $embedUrl }}" 
                                                class="w-full h-full" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                        </iframe>
                                    @else {{-- Ebook --}}
                                        {{-- Coba embed Google Drive viewer --}}
                                        @php
                                            // Ubah URL view biasa menjadi URL embed
                                            $ebookEmbedUrl = str_replace(['/view', '?usp=sharing'], '/preview', $lesson->content_url);
                                        @endphp
                                         <iframe src="{{ $ebookEmbedUrl }}" class="w-full h-full" allow="autoplay"></iframe>
                                    @endif
                                </div>
                                 @if($lesson->lesson_type !== 'video')
                                    <div class="mt-4 text-center">
                                         <a href="{{ $lesson->content_url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition">
                                            <x-heroicon-o-arrow-top-right-on-square class="w-5 h-5 mr-2"/>
                                            Buka Ebook di Tab Baru
                                         </a>
                                    </div>
                                @endif

                                @if($isEnrolled && $lesson->assignments->count())
                                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                                        <h4 class="text-md font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
                                             <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-blue-500"/>
                                             Tugas Terkait Materi Ini
                                        </h4>
                                        <div class="space-y-4">
                                            @foreach($lesson->assignments as $assignment)
                                                <div x-data="{ open: assignmentOpen[{{ $assignment->id }}] === undefined ? false : assignmentOpen[{{ $assignment->id }}] }" id="assignment-{{ $assignment->id }}" class="border dark:border-gray-700 rounded-lg overflow-hidden">
                                                    {{-- Header Accordion Tugas --}}
                                                    <button @click="open = !open; assignmentOpen[{{ $assignment->id }}] = open" class="w-full flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $assignment->title }}</span>
                                                         <x-heroicon-s-chevron-down class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" ::class="{'rotate-180': open}"/>
                                                    </button>

                                                    {{-- Konten Accordion Tugas --}}
                                                    <div x-show="open" x-collapse x-cloak class="p-4 border-t dark:border-gray-600">
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 prose prose-sm dark:prose-invert max-w-none">{{ $assignment->description }}</p>
                                                        
                                                         @php $mySubmission = $assignment->submissions->where('user_id', auth()->id())->first(); @endphp
                                                        
                                                        {{-- Tampilkan Status & Hasil Jika Sudah Submit --}}
                                                        @if($mySubmission)
                                                            <div class="mb-4 p-3 bg-indigo-50 dark:bg-gray-700 rounded-md border border-indigo-200 dark:border-gray-600 text-sm space-y-1">
                                                                <p><strong>Status Pengiriman:</strong> 
                                                                    @if(is_null($mySubmission->grade))
                                                                         <span class="font-medium text-yellow-700 dark:text-yellow-300">Menunggu Penilaian</span>
                                                                    @else
                                                                         <span class="font-medium text-green-700 dark:text-green-300">Sudah Dinilai</span>
                                                                    @endif
                                                                </p>
                                                                <p><strong>Nilai:</strong> <span class="font-semibold">{{ $mySubmission->grade ?? '-' }}</span></p>
                                                                <p><strong>Feedback:</strong> <span class="italic">{{ $mySubmission->feedback_comment ?? '-' }}</span></p>
                                                                <p><strong>Link Terkirim:</strong> <a href="{{$mySubmission->google_drive_link}}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline truncate inline-block max-w-xs">{{$mySubmission->google_drive_link}}</a></p>
                                                            </div>
                                                        @endif

                                                        {{-- Form Submit (atau pesan jika sudah submit) --}}
                                                         <form method="POST" action="{{ route('assignments.submit', $assignment) }}" class="space-y-3">
                                                            @csrf
                                                            <div>
                                                                <label for="google_drive_link_{{ $assignment->id }}" class="sr-only">Link Google Drive</label>
                                                                <div class="relative">
                                                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                                        <x-heroicon-o-link class="w-5 h-5 text-gray-400"/>
                                                                    </div>
                                                                     {{-- Beri nilai default jika sudah pernah submit --}}
                                                                    <x-text-input type="url" name="google_drive_link" id="google_drive_link_{{ $assignment->id }}" 
                                                                                  class="block w-full pl-10" 
                                                                                  placeholder="https://docs.google.com/document/d/..." 
                                                                                  :value="$mySubmission?->google_drive_link ?? old('google_drive_link')"
                                                                                  required />
                                                                </div>
                                                                 <x-input-error :messages="$errors->get('google_drive_link')" class="mt-2" />
                                                            </div>
                                                            <x-primary-button>
                                                                <x-heroicon-o-paper-airplane class="w-5 h-5 mr-2 -ml-1 rotate-45"/>
                                                                {{ $mySubmission ? 'Update Link Tugas' : 'Kirim Link Tugas' }}
                                                            </x-primary-button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif 
                            </div>
                        </div>
                    @empty
                         <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden p-6 text-center text-gray-500 dark:text-gray-400">
                             Pilih materi dari daftar di samping untuk memulai.
                         </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>