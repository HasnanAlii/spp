<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Detail Transaksi') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <a href="{{ route('keuangan.index') }}" class="hover:text-blue-600 transition-colors">Keuangan</a>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Rincian #{{ $keuangan->id }}</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI --}}
            <div class="mb-6">
                <a href="{{ route('keuangan.index') }}" 
                   class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors duration-200 group">
                    <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 group-hover:border-blue-200 group-hover:bg-blue-50 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    Kembali ke Daftar Keuangan
                </a>
            </div>

            {{-- MAIN CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100 relative">
                
                {{-- Decorative Top Border --}}
                <div class="h-2 w-full {{ $keuangan->arus_dana == 'masuk' ? 'bg-gradient-to-r from-emerald-400 to-teal-500' : 'bg-gradient-to-r from-rose-500 to-orange-500' }}"></div>

                {{-- CARD HEADER --}}
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">ID Transaksi</p>
                        <h3 class="text-xl font-bold text-slate-800 font-mono tracking-wide">#{{ str_pad($keuangan->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Waktu Pencatatan</p>
                        <div class="flex items-center justify-end gap-1.5 text-slate-600 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $keuangan->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-10">
                    
                    {{-- UTAMA: JUMLAH HERO --}}
                    <div class="flex flex-col items-center justify-center mb-10 pb-10 border-b border-dashed border-slate-200">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nominal Transaksi</span>
                        
                        <div class="text-5xl font-extrabold font-mono tracking-tight mb-4 {{ $keuangan->arus_dana == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $keuangan->arus_dana == 'masuk' ? '+' : '-' }} Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                        </div>

                        {{-- BADGE JENIS --}}
                        @if($keuangan->arus_dana == 'masuk')
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Pemasukan Dana
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                                Pengeluaran Dana
                            </span>
                        @endif
                    </div>

                    {{-- DETAIL GRID --}}
                    <div class="space-y-6">
                        
                        {{-- Keterangan Box --}}
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Keterangan / Uraian
                            </label>
                            <div class="text-slate-700 text-base leading-relaxed font-medium">
                                {{ $keuangan->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                            </div>
                        </div>

                        {{-- Metadata Tambahan (Grid) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white border border-slate-100 p-4 rounded-xl">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Tanggal Transaksi</span>
                                <span class="text-slate-800 font-semibold">{{ $keuangan->created_at->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="bg-white border border-slate-100 p-4 rounded-xl text-right">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Dicatat Oleh</span>
                                <span class="text-slate-800 font-semibold">{{ Auth::user()->name }}</span>
                            </div>
                        </div>

                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="pt-8 mt-8 border-t border-slate-100 flex justify-end gap-3">
                        
                        {{-- EDIT BUTTON (Optional) --}}
                        {{-- <a href="{{ route('keuangan.edit', $keuangan) }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-50 text-yellow-700 font-bold rounded-xl border border-yellow-100 hover:bg-yellow-100 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Data
                        </a> --}}

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('keuangan.destroy', $keuangan) }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus data keuangan ini? Saldo akhir akan terpengaruh.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-rose-50 text-rose-600 font-bold rounded-xl border border-rose-100 hover:bg-rose-600 hover:text-white hover:shadow-lg hover:shadow-rose-200 transition-all duration-300">
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