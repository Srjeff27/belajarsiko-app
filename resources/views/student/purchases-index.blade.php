<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Pembelian
        </h2>
    </x-slot>

    <div class="py-8 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    @if($transactions->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kursus</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($transactions as $t)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $t->created_at->format('d M Y H:i') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $t->course?->title ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $map = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                        'waiting_verification' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
                                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                    ];
                                                    $label = [
                                                        'pending' => 'Pending',
                                                        'waiting_verification' => 'Menunggu Verifikasi',
                                                        'completed' => 'Selesai',
                                                        'failed' => 'Gagal',
                                                    ][$t->status] ?? $t->status;
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $map[$t->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                                    {{ $label }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-600 dark:text-gray-400">Belum ada transaksi.</p>
                            <a href="{{ route('student.courses') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">Jelajahi Kursus</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

