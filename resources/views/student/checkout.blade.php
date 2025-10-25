<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Checkout: <span class="text-indigo-600 dark:text-indigo-400">{{ $course->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">

                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0l.879-.659M7.5 14.818l.879.659c1.171.879 3.07.879 4.242 0l.879-.659M6 18L4.757 15.659a4.5 4.5 0 010-6.318L6 7.5M18 18l1.243-2.341a4.5 4.5 0 000-6.318L18 7.5" />
                            </svg>
                            Detail Pembayaran
                        </h3>

                        <div class="bg-indigo-50 dark:bg-gray-700 p-4 rounded-lg border border-indigo-200 dark:border-gray-600">
                            <p class="text-sm text-indigo-700 dark:text-indigo-300 mb-1">Total yang harus dibayar:</p>
                            <div class="text-3xl font-bold text-indigo-900 dark:text-indigo-100">
                                Rp {{ number_format($course->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300 mb-2">Scan QRIS Berikut:</p>
                            <img src="/images/qris.png" alt="QRIS Code"
                                 class="w-full max-w-[280px] border-4 border-gray-200 dark:border-gray-600 rounded-lg shadow-md mx-auto md:mx-0" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 text-center md:text-left">
                                Gunakan aplikasi E-Wallet atau Mobile Banking Anda untuk melakukan pembayaran.
                            </p>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                             <p><strong>Penting:</strong></p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pastikan jumlah transfer sesuai dengan total di atas.</li>
                                <li>Ambil tangkapan layar (screenshot) bukti transfer setelah berhasil.</li>
                                <li>Upload bukti transfer pada form di samping.</li>
                                <li>Admin akan memverifikasi pembayaran Anda dalam 1x24 jam kerja.</li>
                             </ul>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                           <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                           </svg>
                            Konfirmasi Pembayaran Anda
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 -mt-4">
                            Setelah melakukan pembayaran via QRIS, isi form di bawah ini.
                        </p>

                        <form method="POST" action="{{ route('checkout.course.confirm', $course) }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <div>
                                <label for="payer_name" class="sr-only">Nama Pengirim</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                          <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.78 6.125-2.095a1.23 1.23 0 00.41-1.412A9.99 9.99 0 0010 12.75a9.99 9.99 0 00-6.535 1.743z" />
                                        </svg>
                                    </div>
                                    <x-text-input type="text" name="payer_name" id="payer_name" class="block w-full pl-10" placeholder="Nama Sesuai Bukti Transfer" required />
                                    <x-input-error :messages="$errors->get('payer_name')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label for="payer_bank" class="sr-only">Bank / E-Wallet Sumber</label>
                                <div class="relative">
                                     <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                                        </svg>
                                    </div>
                                    <x-text-input type="text" name="payer_bank" id="payer_bank" class="block w-full pl-10" placeholder="Contoh: BCA, OVO, GoPay, DANA" required />
                                     <x-input-error :messages="$errors->get('payer_bank')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Bukti Transfer (Screenshot)</label>
                                <label for="payment_proof" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 dark:focus-within:ring-offset-gray-800 flex items-center px-3 py-2">
                                     <svg class="w-6 h-6 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                     </svg>
                                    <span id="file-chosen" class="text-sm text-gray-500 dark:text-gray-400">Pilih file gambar...</span>
                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required
                                           onchange="document.getElementById('file-chosen').textContent = this.files[0] ? this.files[0].name : 'Pilih file gambar...'">
                                </label>
                                 <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                            </div>

                            <div class="pt-2">
                                <x-primary-button class="w-full justify-center text-base">
                                     <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                     </svg>
                                    {{ __('Konfirmasi Pembayaran Saya') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>