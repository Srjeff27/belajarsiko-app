<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Checkout: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-300">Jumlah bayar:</p>
                    <div class="text-2xl font-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</div>
                </div>
                <div class="mb-4">
                    <p class="font-semibold mb-2">QRIS</p>
                    <img src="/images/qris.png" alt="QRIS" class="w-64 border" />
                    <p class="text-xs text-gray-500 mt-2">Gunakan QRIS di atas untuk pembayaran.</p>
                </div>

                <form method="POST" action="{{ route('checkout.course.confirm', $course) }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm mb-1">Nama Pengirim</label>
                        <input type="text" name="payer_name" class="w-full border rounded p-2 dark:bg-gray-900" required />
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Bank / E-Wallet Sumber</label>
                        <input type="text" name="payer_bank" class="w-full border rounded p-2 dark:bg-gray-900" required />
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Upload Bukti Transfer (screenshot)</label>
                        <input type="file" name="payment_proof" accept="image/*" class="w-full border rounded p-2 dark:bg-gray-900" required />
                    </div>
                    <button class="px-4 py-2 bg-amber-600 text-white rounded">Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

