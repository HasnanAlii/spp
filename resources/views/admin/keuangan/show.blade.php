<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                
                {{-- CARD HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        Rincian Data Keuangan
                    </span>

                    <a href="{{ route('keuangan.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- UTAMA: JENIS & JUMLAH --}}
                    <div class="flex flex-col items-center justify-center mb-8 pb-8 border-b border-dashed border-gray-200">
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Total Transaksi</span>
                        
                        <div class="text-4xl md:text-5xl font-extrabold {{ $keuangan->arus_dana == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }} mb-4">
                            Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                        </div>

                        {{-- BADGE JENIS --}}
                        @if($keuangan->arus_dana == 'masuk')
                            <span class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Pemasukan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full text-sm font-bold bg-rose-100 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                                Pengeluaran
                            </span>
                        @endif
                    </div>

                    {{-- DETAIL GRID --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        {{-- Keterangan --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan</label>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-gray-700 leading-relaxed">
                                {{ $keuangan->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Transaksi</label>
                            <div class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $keuangan->created_at->format('d F Y') }}
                            </div>
                        </div>

                        {{-- Waktu Input --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Waktu Input</label>
                            <div class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $keuangan->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                        
                        {{-- EDIT BUTTON --}}
                        {{-- <a href="{{ route('keuangan.edit', $keuangan) }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-100 text-yellow-700 font-bold rounded-xl hover:bg-yellow-200 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a> --}}

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('keuangan.destroy', $keuangan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Data tidak dapat dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg hover:bg-red-700 hover:shadow-red-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Hapus Transaksi
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>