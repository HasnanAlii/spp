<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Detail Transaksi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                {{-- CARD HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        Transaksi #{{ $pembayaran->id }}
                    </span>

                    <a href="{{ route('pembayaran.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8 space-y-8">

                    {{-- SECTION 1: INFORMASI SISWA --}}
                    <div>
                        <h4 class="font-bold text-blue-800 flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi Siswa
                        </h4>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Siswa</label>
                                    <p class="text-gray-800 font-bold text-lg">{{ $pembayaran->siswa->nama ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kelas</label>
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">
                                        {{ $pembayaran->siswa->kelas ?? 'N/A' }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIS</label>
                                    <p class="text-gray-700 font-mono">{{ $pembayaran->siswa->nisn ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Telepon</label>
                                    <p class="text-gray-700">{{ $pembayaran->siswa->telp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: DETAIL PEMBAYARAN (CONDITIONAL) --}}
                    <div>
                        <h4 class="font-bold text-blue-800 flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Rincian Item Pembayaran
                        </h4>

                        {{-- BULANAN --}}
                        {{-- @if($pembayaran->bulanan) --}}
                            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-lg font-bold">UDB (Bulanan)</span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs text-blue-400 uppercase font-bold mb-1">Pembayaran Untuk</label>
                                        <p class="font-semibold text-blue-900">{{ $pembayaran->sppSiswa->nama_spp ?? '-' }} {{ $pembayaran->bulanan->tahun ?? '' }}</p>
                                    </div>
                                    <div class="col-span-2 md:col-span-1">
                                        <label class="block text-xs text-blue-400 uppercase font-bold mb-1">Nominal</label>
                                        <p class="font-bold text-lg text-blue-700">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        {{-- @endif --}}

                        {{-- TAHUNAN --}}
                        @if($pembayaran->tahunan)
                            <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-100 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="bg-emerald-600 text-white text-xs px-3 py-1 rounded-lg font-bold">UDT (Tahunan)</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs text-emerald-500 uppercase font-bold mb-1">Item</label>
                                        <p class="font-semibold text-emerald-900">{{ $pembayaran->tahunan->nama_pembayaran ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-emerald-500 uppercase font-bold mb-1">Tahun Ajaran</label>
                                        <p class="font-medium text-emerald-800">{{ $pembayaran->tahunan->tahun_ajaran ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-emerald-500 uppercase font-bold mb-1">Nominal</label>
                                        <p class="font-bold text-lg text-emerald-700">Rp {{ number_format($pembayaran->tahunan->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- LAINNYA --}}
                        @if($pembayaran->pembayaranLainnya)
                            <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-lg font-bold">Lainnya</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs text-purple-400 uppercase font-bold mb-1">Keterangan</label>
                                        <p class="font-semibold text-purple-900">{{ $pembayaran->pembayaranLainnya->nama_pembayaran ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-purple-400 uppercase font-bold mb-1">Catatan</label>
                                        <p class="font-medium text-purple-800 text-sm">{{ $pembayaran->pembayaranLainnya->keterangan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-purple-400 uppercase font-bold mb-1">Nominal</label>
                                        <p class="font-bold text-lg text-purple-700">Rp {{ number_format($pembayaran->pembayaranLainnya->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- SECTION 3: TOTAL & METADATA --}}
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                            
                            {{-- Metadata --}}
                            <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-500">
                                <div>
                                    <span class="font-bold text-xs uppercase tracking-wider block mb-1">Tanggal Transaksi</span>
                                    <span class="text-gray-800">{{ $pembayaran->created_at->format('d F Y') }}</span>
                                </div>
                                {{-- <div>
                                    <span class="font-bold text-xs uppercase tracking-wider block mb-1">Terakhir Update</span>
                                    <span class="text-gray-800">{{ $pembayaran->updated_at->format('d/m/Y H:i') }}</span>
                                </div> --}}
                            </div>

                            {{-- Total Calculation --}}
                            {{-- @php
                                $total = 0;
                                if($pembayaran->bulanan) $total += $pembayaran->bulanan->jumlah;
                                if($pembayaran->tahunan) $total += $pembayaran->tahunan->jumlah;
                                if($pembayaran->pembayaranLainnya) $total += $pembayaran->pembayaranLainnya->jumlah;
                            @endphp --}}

                            <div class="text-right">
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pembayaran</span>
                                <span class="text-3xl font-extrabold text-blue-700">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                        {{-- Edit --}}
                        {{-- <a href="{{ route('pembayaran.edit', $pembayaran) }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-100 text-yellow-700 font-bold rounded-xl hover:bg-yellow-200 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a> --}}

                        {{-- Delete --}}
                        <form action="{{ route('pembayaran.destroy', $pembayaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg hover:bg-red-700 hover:shadow-red-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>