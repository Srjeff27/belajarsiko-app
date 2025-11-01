<x-guest-layout>
    <div class="text-center">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Verifikasi Sertifikat</h1>
        <p class="text-sm text-gray-600 mb-6">Periksa keaslian sertifikat dengan kode unik.</p>

        <div class="mb-6">
            <form method="GET" action="{{ route('certificate.verify') }}" class="flex gap-2 justify-center">
                <input name="code" type="text" value="{{ $code ?? '' }}" placeholder="Masukkan kode (contoh: RQ5AHGUJAS)" class="w-64 sm:w-80 px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Cek</button>
            </form>
        </div>

        @if($certificate)
            <div class="rounded-xl border border-green-200 bg-green-50 p-5 text-left">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-green-700 font-semibold">Sertifikat VALID</span>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Nama Peserta</dt>
                        <dd class="font-medium text-gray-900">{{ $certificate->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Kode Unik</dt>
                        <dd class="font-mono font-semibold text-gray-900">{{ $certificate->unique_code }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Kursus</dt>
                        <dd class="font-medium text-gray-900">{{ $certificate->course->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tanggal Terbit</dt>
                        <dd class="font-medium text-gray-900">{{ optional($certificate->generated_at)->isoFormat('D MMMM YYYY') ?? '-' }}</dd>
                    </div>
                    @if(!empty($certificate->formal_number))
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500">Nomor Sertifikat</dt>
                            <dd class="font-medium text-gray-900">{{ $certificate->formal_number }}</dd>
                        </div>
                    @endif
                </dl>

                <div class="mt-5 text-xs text-gray-600">
                    Halaman ini hanya menampilkan status keabsahan. Untuk mengunduh file sertifikat, silakan login ke akun peserta.
                </div>
            </div>
        @elseif(!empty($code))
            <div class="rounded-xl border border-red-200 bg-red-50 p-5">
                <div class="flex items-center gap-2 justify-center mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-red-700 font-semibold">Kode tidak ditemukan</span>
                </div>
                <p class="text-sm text-gray-700">Pastikan kode yang dimasukkan benar. Jika perlu bantuan, hubungi admin.</p>
            </div>
        @endif

        <div class="mt-6">
            <a href="/" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Kembali ke beranda</a>
        </div>
    </div>
</x-guest-layout>
