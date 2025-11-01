<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div x-data="{ activeLessonId: @js($course->lessons->first()?->id), assignmentOpen: {} }" class="py-8 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8 space-y-6 lg:space-y-0">

                {{-- Left column: description + lessons list --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
                                <x-heroicon-o-information-circle class="w-6 h-6 text-indigo-500"/>
                                Deskripsi Kursus
                            </h3>

                            @if($course->category?->name)
                                <p class="mb-2 text-xs inline-flex items-center gap-1 px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                                    <x-heroicon-s-tag class="w-3 h-3"/> {{ $course->category->name }}
                                </p>
                            @endif

                            <p class="text-sm text-gray-700 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">
                                {{ $course->description }}
                            </p>

                            @unless($isEnrolled)
                                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Daftar Kelas Ini</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Dapatkan akses penuh ke semua materi dan tugas.</p>
                                    @if($course->is_premium)
                                        <a href="{{ route('checkout.course', $course) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700">
                                            <x-heroicon-o-shopping-cart class="w-5 h-5 mr-2 -ml-1"/>
                                            Beli Kelas (Rp {{ number_format($course->price, 0, ',', '.') }})
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700">
                                                <x-heroicon-o-plus class="w-5 h-5 mr-2 -ml-1"/>
                                                Ambil Kelas
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Kelas Sudah Diambil Semua</p>
                                </div>
                            @endunless
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
                                        $isCompleted = $completedLessons->contains($lesson->id);
                                        $isAccessible = $isEnrolled || $loop->first;
                                    @endphp

                                    @if($isAccessible)
                                        <button @click="activeLessonId = {{ $lesson->id }}" :class="{ 'bg-indigo-100 dark:bg-indigo-900 border-l-4 border-indigo-500': activeLessonId === {{ $lesson->id }}, 'hover:bg-gray-100 dark:hover:bg-gray-700': activeLessonId !== {{ $lesson->id }} }" class="w-full flex items-center justify-between text-left p-3 rounded-md transition-colors duration-200 border border-transparent dark:border-gray-700">
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
                                    @else
                                        <div class="w-full flex items-center justify-between text-left p-3 rounded-md bg-gray-50 dark:bg-gray-800 opacity-70 border border-transparent dark:border-gray-700" title="Kunci - Ambil kelas untuk membuka materi ini">
                                            <div class="flex items-center gap-3">
                                                <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400 dark:text-gray-500 flex-shrink-0"/>
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $lesson->title }}</span>
                                            </div>
                                            <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400 dark:text-gray-500 flex-shrink-0"/>
                                        </div>
                                    @endif

                                    

                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada materi ditambahkan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right column: lesson content --}}
                <div class="lg:col-span-2 space-y-6">
                    @forelse($course->lessons as $lesson)
                        @php $isAccessible = $isEnrolled || $loop->first; @endphp

                        <div x-show="activeLessonId === {{ $lesson->id }}" x-transition x-cloak class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                            <div class="p-6">
                                @if($isAccessible)
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

                                        @php $canDiscuss = $isEnrolled || (auth()->check() && ($course->user_id === auth()->id() || auth()->user()->hasRole('admin'))); @endphp
                                        @if($canDiscuss)
                                            @php $isCompleted = $completedLessons->contains($lesson->id); @endphp
                                            <form method="POST" action="{{ route('lessons.complete', $lesson) }}">
                                                @csrf
                                                <button type="submit" @disabled($isCompleted) @class(['inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800','bg-green-600 text-white hover:bg-green-700 focus:ring-green-500' => !$isCompleted,'bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-400 cursor-not-allowed' => $isCompleted])>
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
                                            @php $embedUrl = str_replace('watch?v=', 'embed/', $lesson->content_url) . '?rel=0&modestbranding=1'; @endphp
                                            <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        @else
                                            @php $ebookEmbedUrl = str_replace(['/view', '?usp=sharing'], '/preview', $lesson->content_url); @endphp
                                            <iframe src="{{ $ebookEmbedUrl }}" class="w-full h-full" allow="autoplay"></iframe>
                                        @endif
                                    </div>

                                    @if($lesson->lesson_type !== 'video')
                                        <div class="mt-4 text-center">
                                            <a href="{{ $lesson->content_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition">
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
                                                        <button @click="open = !open; assignmentOpen[{{ $assignment->id }}] = open" class="w-full flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $assignment->title }}</span>
                                                            <x-heroicon-s-chevron-down class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" x-bind:class="{'rotate-180': open}"/>
                                                        </button>

                                                        <div x-show="open" x-collapse x-cloak class="p-4 border-t dark:border-gray-600">
                                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 prose prose-sm dark:prose-invert max-w-none">{{ $assignment->description }}</p>
                                                            @php $mySubmission = $assignment->submissions->where('user_id', auth()->id())->first(); @endphp
                                                            @if($mySubmission)
                                                                <div class="mb-4 p-3 bg-indigo-50 dark:bg-gray-700 rounded-md border border-indigo-200 dark:border-gray-600 text-sm space-y-1">
                                                                    <p><strong>Status Pengiriman:</strong> @if(is_null($mySubmission->grade)) <span class="font-medium text-yellow-700 dark:text-yellow-300">Menunggu Penilaian</span> @else <span class="font-medium text-green-700 dark:text-green-300">Sudah Dinilai</span> @endif</p>
                                                                    <p><strong>Nilai:</strong> <span class="font-semibold">{{ $mySubmission->grade ?? '-' }}</span></p>
                                                                    <p><strong>Feedback:</strong> <span class="italic">{{ $mySubmission->feedback_comment ?? '-' }}</span></p>
                                                                    <p><strong>Link Terkirim:</strong> <a href="{{$mySubmission->google_drive_link}}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline truncate inline-block max-w-xs">{{$mySubmission->google_drive_link}}</a></p>
                                                                </div>
                                                            @endif

                                                            <form method="POST" action="{{ route('assignments.submit', $assignment) }}" class="space-y-3">
                                                                @csrf
                                                                <div>
                                                                    <label for="google_drive_link_{{ $assignment->id }}" class="sr-only">Link Google Drive</label>
                                                                    <div class="relative">
                                                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                                            <x-heroicon-o-link class="w-5 h-5 text-gray-400"/>
                                                                        </div>
                                                                        <x-text-input type="url" name="google_drive_link" id="google_drive_link_{{ $assignment->id }}" class="block w-full pl-10" placeholder="https://docs.google.com/document/d/..." :value="$mySubmission?->google_drive_link ?? old('google_drive_link')" required />
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

                                    {{-- Discussion Section (placed after tasks, YouTube-like) --}}
                                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                                        <h4 class="text-md font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                                            <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-indigo-500"/>
                                            Diskusi Materi
                                        </h4>

                                        {{-- Input ala YouTube --}}
                                        @if($isEnrolled)
                                            <div class="flex items-start gap-3 mb-4">
                                                <span class="inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 rounded-full bg-indigo-100 text-indigo-700 font-semibold">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </span>
                                                <form method="POST" action="{{ route('lessons.discussions.store', $lesson) }}" class="flex-1">
                                                    @csrf
                                                    <textarea name="content" rows="2" class="w-full border-0 border-b border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-0 resize-none" placeholder="Tulis komentar publik..." required></textarea>
                                                    <div class="flex flex-col sm:flex-row items-center gap-3 mt-2">
                                                        <x-text-input name="google_drive_link" type="url" class="w-full grow" placeholder="Link Google Drive (opsional)" />
                                                        <x-primary-button class="w-full sm:w-auto shrink-0">Kirim</x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        {{-- Kontrol urutan komentar --}}
                                        @php $commentSort = request('csort', 'new'); @endphp
                                        <div class="flex items-center justify-end gap-3 mb-3 text-sm">
                                            <span class="text-gray-500">Urutkan:</span>
                                            <a href="{{ request()->fullUrlWithQuery(['csort' => 'new']) }}" class="hover:underline {{ $commentSort==='new' ? 'text-indigo-600 font-medium' : 'text-gray-600' }}">Terbaru</a>
                                            <span class="text-gray-400">|</span>
                                            <a href="{{ request()->fullUrlWithQuery(['csort' => 'top']) }}" class="hover:underline {{ $commentSort==='top' ? 'text-indigo-600 font-medium' : 'text-gray-600' }}">Teratas</a>
                                        </div>

                                        {{-- Daftar komentar/topik --}}
                                        <div class="space-y-5">
                                            @forelse($lesson->discussions->sortByDesc('created_at') as $discussion)
                                                <div class="flex flex-col sm:flex-row items-start gap-3">
                                                    <span class="inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 rounded-full bg-gray-200 text-gray-700 font-semibold">
                                                        {{ strtoupper(substr($discussion->user?->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                    <div class="flex-1">
                                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                                            <span class="font-medium text-gray-900 dark:text-gray-200">{{ $discussion->user?->name ?? 'Pengguna' }}</span>
                                                            <span class="mx-2">•</span>
                                                            <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $discussion->content }}</div>
                                                        @if($discussion->google_drive_link)
                                                            <div class="mt-1"><a class="text-indigo-600 hover:underline" href="{{ $discussion->google_drive_link }}" target="_blank">Lampiran (Google Drive)</a></div>
                                                        @endif

                                                        @php
                                                            $canManageDiscussion = auth()->check() && ($discussion->user_id === auth()->id() || $course->user_id === auth()->id() || auth()->user()->hasRole('admin'));
                                                        @endphp
                                                        @if($canManageDiscussion)
                                                            <div x-data="{ openEdit: false }" class="mt-2 flex items-center gap-3 text-xs">
                                                                <button type="button" @click="openEdit = !openEdit" class="text-gray-600 hover:underline">Edit</button>
                                                                <form method="POST" action="{{ route('discussions.destroy', $discussion) }}" onsubmit="return confirm('Hapus diskusi ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                                                </form>
                                                            </div>
                                                            <div x-show="openEdit" x-cloak class="mt-2">
                                                                <form method="POST" action="{{ route('discussions.update', $discussion) }}" class="space-y-2">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500" required>{{ $discussion->content }}</textarea>
                                                                    <x-text-input name="google_drive_link" type="url" class="w-full" placeholder="Link Google Drive (opsional)" :value="$discussion->google_drive_link" />
                                                                    <x-primary-button type="submit">Simpan</x-primary-button>
                                                                </form>
                                                            </div>
                                                        @endif

                                                        {{-- Balasan --}}
                                                        <div class="mt-3 space-y-3">
                                                            @php 
                                                                $comments = $discussion->comments;
                                                                if($commentSort === 'top') { $comments = $comments->sortByDesc('likes_count'); }
                                                                else { $comments = $comments->sortByDesc('created_at'); }
                                                            @endphp
                                                            @foreach($comments as $comment)
                                                                <div class="flex flex-col sm:flex-row items-start gap-3">
                                                                    <span class="inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 rounded-full bg-gray-200 text-gray-700 font-semibold">
                                                                        {{ strtoupper(substr($comment->user?->name ?? 'U', 0, 1)) }}
                                                                    </span>
                                                                    <div class="flex-1 text-sm">
                                                                        <div class="text-gray-600 dark:text-gray-400">
                                                                            <span class="font-medium text-gray-900 dark:text-gray-200">{{ $comment->user?->name ?? 'Pengguna' }}</span>
                                                                            <span class="mx-2">•</span>
                                                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <div class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $comment->content }}</div>
                                                                        @if($comment->google_drive_link)
                                                                            <div class="mt-1"><a class="text-indigo-600 hover:underline" href="{{ $comment->google_drive_link }}" target="_blank">Lampiran (Google Drive)</a></div>
                                                                        @endif

                                                                        <div class="mt-2 flex items-center gap-3">
                                                                            <form method="POST" action="{{ route('comments.like', $comment) }}">
                                                                                @csrf
                                                                                <button type="submit" class="inline-flex items-center gap-1 text-xs text-gray-600 hover:text-indigo-600">
                                                                                    <x-heroicon-o-hand-thumb-up class="w-4 h-4"/>
                                                                                    <span>{{ $comment->likes_count }}</span>
                                                                                </button>
                                                                            </form>

                                                                            @php
                                                                                $canManageComment = auth()->check() && ($comment->user_id === auth()->id() || $course->user_id === auth()->id() || auth()->user()->hasRole('admin'));
                                                                            @endphp
                                                                            @if($canManageComment)
                                                                                <div x-data="{ editOpen: false }" class="inline-flex items-center gap-2">
                                                                                    <button type="button" @click="editOpen = !editOpen" class="text-xs text-gray-600 hover:underline">Edit</button>
                                                                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Hapus komentar ini?')">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                                                                                    </form>
                                                                                    <div x-show="editOpen" x-cloak class="mt-2 w-full">
                                                                                        <form method="POST" action="{{ route('comments.update', $comment) }}" class="space-y-2">
                                                                                            @csrf
                                                                                            @method('PATCH')
                                                                                            <textarea name="content" rows="2" class="w-full border-0 border-b border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-0 resize-none" required>{{ $comment->content }}</textarea>
                                                                                            <x-text-input name="google_drive_link" type="url" class="w-full" placeholder="Link Google Drive (opsional)" :value="$comment->google_drive_link" />
                                                                                            <x-secondary-button type="submit">Simpan</x-secondary-button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            {{-- Form balasan --}}
                                                            @if($canDiscuss)
                                                                <form method="POST" action="{{ route('discussions.comments.store', $discussion) }}" class="flex items-start gap-3">
                                                                    @csrf
                                                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                                                    <div class="flex-1">
                                                                        <textarea name="content" rows="1" class="w-full border-0 border-b border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-0 resize-none" placeholder="Tulis balasan..." required></textarea>
                                                                        <div class="flex flex-col sm:flex-row items-center gap-3 mt-2">
                                                                            <x-text-input name="google_drive_link" type="url" class="w-full grow" placeholder="Link Google Drive (opsional)" />
                                                                            <x-secondary-button type="submit" class="w-full sm:w-auto shrink-0">Balas</x-secondary-button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada komentar.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    @else
                                        <div class="p-6 text-center text-gray-700 dark:text-gray-300">
                                            <div class="mb-4">
                                                <x-heroicon-o-lock-closed class="w-12 h-12 mx-auto text-gray-400"/>
                                            </div>
                                            <h3 class="text-lg font-semibold mb-2">Materi Terkunci</h3>
                                            <p class="mb-4">Ambil atau beli kelas ini untuk membuka semua materi.</p>
                                            @unless($isEnrolled)
                                                @if($course->is_premium)
                                                    <a href="{{ route('checkout.course', $course) }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700">
                                                        <x-heroicon-o-shopping-cart class="w-5 h-5 mr-2"/> Beli Kelas (Rp {{ number_format($course->price, 0, ',', '.') }})
                                                    </a>
                                                @else
                                                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700">
                                                            <x-heroicon-o-plus class="w-5 h-5 mr-2"/> Ambil Kelas
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <p class="mb-4">Kelas Sudah Diambil Semua</p>
                                            @endunless
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
