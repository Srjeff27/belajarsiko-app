<x-guest-layout>
    <div class="text-center max-w-2xl mx-auto">
        
        {{-- [UBAH] Judul lebih besar dan spasi lebih baik --}}
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-3">
            Verifikasi Keaslian Sertifikat
        </h1>
        <p class="text-lg text-gray-500 mb-8">
            Periksa keabsahan sertifikat yang kami terbitkan menggunakan kode unik.
        </p>

        {{-- [UBAH] Formulir yang didesain ulang --}}
        <div class="mb-10">
            <form method="GET" action="{{ route('certificate.verify') }}" class="flex gap-3 max-w-lg mx-auto">
                <input name="code" type="text" value="{{ $code ?? '' }}" 
                       placeholder="Masukkan kode unik (contoh: RQ5AHGUJAS)" 
                       class="flex-grow w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm placeholder-gray-400">
                
                <button type="submit" 
                        class="flex-shrink-0 inline-flex items-center px-5 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm transition duration-150 font-semibold">
                    Cek
                    <x-heroicon-s-arrow-right class="w-5 h-5 ml-2" />
                </button>
            </form>
        </div>

        {{-- Wrapper untuk hasil pencarian --}}
        <div class="mt-10">

            @if($certificate)
                {{-- [UBAH] Kartu hasil VALID yang didesain ulang total --}}
                <div class="rounded-2xl border border-green-300 bg-green-50 p-6 sm:p-8 text-left shadow-lg">
                    
                    {{-- Header Kartu --}}
                    <div class="flex items-center gap-3 mb-5">
                        <x-heroicon-s-check-badge class="h-8 w-8 text-green-600 flex-shrink-0" />
                        <span class="text-2xl font-bold text-green-800">Sertifikat Ditemukan dan VALID</span>
                    </div>

                    {{-- Data Detail --}}
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 pt-5 border-t border-green-200">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Peserta</dt>
                            <dd class="text-base font-semibold text-gray-900 mt-1">{{ $certificate->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kursus</dt>
                            <dd class="text-base font-semibold text-gray-900 mt-1">{{ $certificate->course->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Unik</dt>
                            <dd class="font-mono font-semibold text-gray-900 text-base mt-1">{{ $certificate->unique_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Terbit</dt>
                            <dd class="text-base font-semibold text-gray-900 mt-1">{{ optional($certificate->generated_at)->isoFormat('D MMMM YYYY') ?? '-' }}</dd>
                        </div>
                        @if(!empty($certificate->formal_number))
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Nomor Sertifikat</dt>
                                <dd class="text-base font-semibold text-gray-900 mt-1">{{ $certificate->formal_number }}</dd>
                            </div>
                        @endif
                    </dl>

                    {{-- Catatan Kaki Kartu --}}
                    <div class="mt-6 pt-5 border-t border-green-200 text-sm text-gray-600">
                        Halaman ini hanya menampilkan status keabsahan. Untuk mengunduh file sertifikat, silakan login ke akun peserta yang bersangkutan.
                    </div>
                </div>

            @elseif(!empty($code))
                {{-- [UBAH] Kartu hasil TIDAK VALID yang didesain ulang --}}
                <div class="rounded-2xl border border-red-300 bg-red-50 p-6 sm:p-8 shadow-lg text-center">
                    <x-heroicon-s-x-circle class="h-10 w-10 text-red-600 mx-auto" />
                    <h3 class="text-xl font-bold text-red-800 mt-4">Sertifikat Tidak Ditemukan</h3>
                    <p class="text-base text-red-700 mt-2">
                        Kode <strong>{{ $code }}</strong> tidak terdaftar di sistem kami.
                    </p>
                    <p class="text-sm text-gray-700 mt-1">
                        Pastikan kode yang dimasukkan sudah benar. Jika Anda yakin ini adalah kesalahan, silakan hubungi admin.
                    </p>
                </div>
            @endif

        </div>

        {{-- [UBAH] Link kembali dengan ikon dan spasi lebih baik --}}
        <div class="mt-10">
            <a href="/" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center gap-1.5 group">
                <x-heroicon-s-arrow-left class="w-4 h-4 transition-transform group-hover:-translate-x-1" />
                Kembali ke beranda
            </a>
        </div>
    </div>
</x-guest-layout>