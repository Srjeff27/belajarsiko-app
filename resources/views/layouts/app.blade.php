<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Belajar Siko') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <div class="min-h-screen flex">
                <!-- Sidebar -->
                <aside class="w-64 bg-white border-r border-gray-200 sticky top-0 h-screen">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <a href="/" class="flex items-center gap-2 font-semibold text-gray-800" wire:navigate>
                            <x-application-logo class="w-6 h-6" />
                            <span>Belajar Siko</span>
                        </a>
                    </div>
                    <nav class="p-3">
                        @php
                            $items = [
                                ['label' => 'Dashboard', 'route' => 'dashboard', 'href' => route('dashboard')],
                                ['label' => 'Kelas', 'route' => 'student.courses', 'href' => route('student.courses')],
                                ['label' => 'Tugas', 'route' => 'student.assignments', 'href' => route('student.assignments')],
                                ['label' => 'Sertifikat', 'route' => 'student.certificates', 'href' => route('student.certificates')],
                            ];
                        @endphp
                        <ul class="space-y-1">
                            @foreach($items as $item)
                                <li>
                                    <a href="{{ $item['href'] }}" wire:navigate
                                       @class([
                                          'flex items-center gap-2 px-3 py-2 rounded-md text-sm transition',
                                          'bg-amber-50 text-amber-700 border border-amber-200' => request()->routeIs($item['route']),
                                          'text-gray-700 hover:bg-gray-100' => !request()->routeIs($item['route']),
                                       ])>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </aside>

                <!-- Main content -->
                <main class="flex-1 min-w-0">
                    @if (isset($header))
                        <div class="px-6 py-4 border-b border-gray-200 bg-white">
                            <div class="max-w-7xl mx-auto">
                                {{ $header }}
                            </div>
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="max-w-7xl mx-auto">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
