<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Tambah Transaksi Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                {{-- FORM HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium flex items-center gap-2">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </div>
                        Formulir Keuangan Baru
                    </span>

                    <a href="{{ route('keuangan.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-bold transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('keuangan.store') }}">
                        @csrf

                        <div class="space-y-8">
                            
                            {{-- 1. JENIS TRANSAKSI --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                    Jenis Transaksi *
                                </label>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Radio Pemasukan --}}
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="arus_dana" value="masuk" class="peer sr-only" required>
                                        <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-green-300 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all duration-200 flex items-center gap-3">
                                            <div class="p-2 bg-green-100 text-green-600 rounded-lg peer-checked:bg-green-500 peer-checked:text-white transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="block font-bold text-gray-700 peer-checked:text-green-800">Pemasukan</span>
                                                <span class="block text-xs text-gray-500 peer-checked:text-green-700">Dana masuk </span>
                                            </div>
                                        </div>
                                    </label>

                                    {{-- Radio Pengeluaran --}}
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="arus_dana" value="keluar" class="peer sr-only" required>
                                        <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-red-300 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all duration-200 flex items-center gap-3">
                                            <div class="p-2 bg-red-100 text-red-600 rounded-lg peer-checked:bg-red-500 peer-checked:text-white transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="block font-bold text-gray-700 peer-checked:text-red-800">Pengeluaran</span>
                                                <span class="block text-xs text-gray-500 peer-checked:text-red-700">Dana keluar</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('arus_dana')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- 2. JUMLAH NOMINAL --}}
                            <div>
                                <label for="jumlah" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                    Nominal Transaksi *
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 font-bold">Rp</span>
                                    </div>
                                 <input type="text" id="jumlah_display"
                                    class="pl-12 block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 font-bold text-gray-800 text-lg transition"
                                    placeholder="0" required>

                                 <input type="hidden" name="jumlah" id="jumlah">

                                </div>
                                @error('jumlah')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- 3. KETERANGAN --}}
                            <div>
                                <label for="keterangan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
                                    Keterangan
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3" 
                                          class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                          placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Opsional. Tambahkan detail untuk memudahkan pelaporan.
                                </p>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('keuangan.index') }}"
                                   class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition duration-300">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Simpan Transaksi
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    const displayInput = document.getElementById("jumlah_display");
    const realInput = document.getElementById("jumlah");

    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    displayInput.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, ""); // hapus semua selain angka

        if (value === "") {
            realInput.value = "";
            this.value = "";
            return;
        }

        // set ke input hidden (angka asli)
        realInput.value = value;

        // tampilkan dalam format ribuan
        this.value = formatRupiah(value);
    });
});
</script>

</x-app-layout>