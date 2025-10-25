<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Kelas Saya</h3>

                    @if(isset($enrollments) && $enrollments->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            @foreach($enrollments as $enroll)
                                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                                    
                                    <a href="{{ route('courses.show', $enroll->course) }}">
                                        <img class="w-full h-48 object-cover" 
                                             src="{{ $enroll->course->thumbnail_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                                             alt="{{ $enroll->course->title }}">
                                    </a>

                                    <div class="p-5 flex flex-col flex-grow">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 truncate">{{ $enroll->course->title }}</h4>
                                        
                                        <div class="mb-4">
                                            @php
                                                $courseProgress = $progress[$enroll->course->id] ?? 0;
                                            @endphp
                                            <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                <span>Progres</span>
                                                <span class="font-semibold">{{ $courseProgress }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                <div class="bg-indigo-600 dark:bg-indigo-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $courseProgress }}%"></div>
                                            </div>
                                        </div>

                                        <div class="mt-auto flex flex-col sm:flex-row gap-3">
                                            <a href="{{ route('courses.show', $enroll->course) }}" 
                                               class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                                </svg>
                                                Lanjutkan Belajar
                                            </a>
                                            
                                            @if($courseProgress === 100)
                                                <a href="{{ route('certificate.download', $enroll->course) }}" 
                                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM17.25 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                                    </svg>
                                                    Unduh Sertifikat
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center bg-gray-50 dark:bg-gray-900 p-10 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                            <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                            </svg>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Anda Belum Memiliki Kelas</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                                Sepertinya Anda belum mendaftar di kelas manapun. Ayo mulai perjalanan belajar Anda sekarang!
                            </p>
                            <a href="{{ route('student.courses') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                                Jelajahi Kursus
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

