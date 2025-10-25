<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sertifikat</h2>
    </x-slot>

    <div class="bg-white rounded shadow p-6">
        @if(isset($certificates) && $certificates->count())
            <ul class="space-y-2">
                @foreach($certificates as $cert)
                    <li class="flex items-center justify-between border rounded p-3">
                        <div>
                            <div class="font-semibold">{{ $cert->course->title }}</div>
                            <div class="text-xs text-gray-600">Kode: {{ $cert->unique_code }} • {{ $cert->generated_at->format('d M Y') }}</div>
                        </div>
                        <a class="px-3 py-1.5 bg-emerald-600 text-white rounded text-sm" href="{{ route('certificate.download', $cert->course) }}">Unduh</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Belum ada sertifikat.</p>
        @endif
    </div>
</x-app-layout>
