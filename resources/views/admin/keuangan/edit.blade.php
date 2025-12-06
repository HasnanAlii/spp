<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <a href="{{ route('keuangan.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Transaksi
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-6">Edit Transaksi #{{ $keuangan->id }}</h3>

                    <form method="POST" action="{{ route('keuangan.update', $keuangan) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="arus_dana" class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi *</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $keuangan->arus_dana == 'masuk' ? 'border-green-500 bg-green-50' : '' }}">
                                        <input type="radio" name="arus_dana" value="masuk" 
                                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300"
                                               {{ $keuangan->arus_dana == 'masuk' ? 'checked' : '' }} required>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">Pemasukan</span>
                                            <span class="block text-xs text-gray-500">Uang masuk (contoh: pembayaran siswa)</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $keuangan->arus_dana == 'keluar' ? 'border-red-500 bg-red-50' : '' }}">
                                        <input type="radio" name="arus_dana" value="keluar" 
                                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300"
                                               {{ $keuangan->arus_dana == 'keluar' ? 'checked' : '' }} required>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">Pengeluaran</span>
                                            <span class="block text-xs text-gray-500">Uang keluar (contoh: pembelian alat)</span>
                                        </div>
                                    </label>
                                </div>
                                @error('arus_dana')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah (Rp) *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah" id="jumlah" min="0" step="100" 
                                           value="{{ old('jumlah', $keuangan->jumlah) }}"
                                           class="pl-12 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0" required>
                                </div>
                                @error('jumlah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <div class="mt-1">
                                    <textarea name="keterangan" id="keterangan" rows="3" 
                                              class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Masukkan keterangan transaksi...">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                                </div>
                                @error('keterangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-3 pt-6 border-t">
                                <a href="{{ route('keuangan.show', $keuangan) }}"
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Transaksi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>