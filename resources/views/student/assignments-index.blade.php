<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tugas Saya') }} </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-7 h-7 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75c0-.231-.035-.454-.1-.664M6.75 7.5H18a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25v-9a2.25 2.25 0 012.25-2.25z" />
                        </svg>
                        Daftar Tugas
                    </h3>

                    @if(isset($assignments) && $assignments->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            @foreach($assignments as $a)
                                @php $my = $a->submissions->where('user_id', auth()->id())->first(); @endphp
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl shadow-md overflow-hidden flex flex-col p-5 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">

                                    <div class="mb-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">{{ $a->lesson->course->title }}</span> / <span>{{ $a->lesson->title }}</span>
                                    </div>

                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $a->title }}</h4>

                                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                        </svg>
                                        <span>Batas: {{ $a->due_date ? $a->due_date->isoFormat('dddd, D MMMM YYYY HH:mm') : 'Tidak Ditentukan' }}</span>
                                    </div>

                                    <div class="mb-5">
                                        @if(!$my)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300">
                                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Belum dikirim
                                            </span>
                                        @elseif(is_null($my->grade))
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Menunggu Penilaian
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Dinilai: {{ $my->grade }}
                                            </span>
                                            {{-- Tampilkan Komentar jika ada --}}
                                            @if($my->feedback_comment)
                                            <p class="mt-2 text-xs italic text-gray-500 dark:text-gray-400">"{{ $my->feedback_comment }}"</p>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <a href="{{ route('courses.show', $a->lesson->course) }}#assignment-{{ $a->id }}"
                                           class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition duration-300">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-4.5 0V6.375c0-.621.504-1.125 1.125-1.125h4.018c.489 0 .93.197 1.258.525a1.73 1.73 0 01.525 1.258v4.018a1.125 1.125 0 01-1.125 1.125H13.5zm-4.5-4.5H9" />
                                            </svg>
                                            Buka Tugas
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- <div class="mt-8">
                            {{ $assignments->links() }}
                        </div> --}}

                    @else
                        <div class="text-center bg-gray-50 dark:bg-gray-900 p-10 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                            <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                             </svg>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Tugas</h4>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                                Saat ini belum ada tugas yang tersedia untuk Anda. Periksa kembali nanti!
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>