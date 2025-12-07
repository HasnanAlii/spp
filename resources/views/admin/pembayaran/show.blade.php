<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Detail Transaksi') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <a href="{{ route('pembayaran.index') }}" class="hover:text-blue-600 transition-colors">Riwayat Pembayaran</a>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Invoice #{{ $pembayaran->id }}</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI --}}
            <div class="mb-6">
                <a href="{{ route('pembayaran.index') }}" 
                   class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors duration-200 group">
                    <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 group-hover:border-blue-200 group-hover:bg-blue-50 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    Kembali ke Riwayat
                </a>
            </div>

            {{-- MAIN RECEIPT CARD --}}
                <div class="print-area bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100 relative print:shadow-none print:border-none">

                {{-- Decorative Top Border --}}
                <div class="h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-blue-600"></div>

                {{-- CARD HEADER: STATUS & ID --}}
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">ID Transaksi</p>
                        <h3 class="text-xl font-bold text-slate-800 font-mono tracking-wide">#{{ str_pad($pembayaran->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Bayar</p>
                        <p class="text-sm font-bold text-slate-700">
                            {{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d F Y') }}
                        </p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Pukul {{ $pembayaran->created_at->format('H:i') }} WIB
                        </p>
                    </div>
                </div>

                <div class="p-8 space-y-8">

                    {{-- SECTION 1: JUMLAH DIBAYAR (HERO) --}}
                    <div class="text-center py-4">
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Total Dibayar</p>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 font-mono tracking-tight">
                            Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                        </h1>
                        <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            Pembayaran Berhasil
                        </div>
                    </div>

                    {{-- SECTION 2: INFORMASI SISWA --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Data Siswa
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                <p class="text-slate-800 font-bold">{{ $pembayaran->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kelas</label>
                                <span class="inline-block bg-white border border-slate-200 text-slate-600 text-xs px-2 py-1 rounded-md font-bold shadow-sm">
                                    {{ $pembayaran->siswa->kelas ?? '-' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIS/NISN</label>
                                <p class="text-slate-600 font-mono text-sm">{{ $pembayaran->siswa->user->nis ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: RINCIAN ITEM PEMBAYARAN --}}
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                            Rincian Item
                        </h4>

                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <table class="min-w-full divide-y divide-slate-100">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100">
                                    <tr>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-slate-800">{{ $pembayaran->sppSiswa->nama_spp }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Tahun Ajaran: {{ $pembayaran->sppSiswa->tahun_ajaran ?? '-' }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $tipe = $pembayaran->sppSiswa->tipe;
                                                $badgeClass = match($tipe) {
                                                    'bulanan' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                    'tahunan' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                                    default => 'bg-slate-50 text-slate-700 border-slate-100',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold border {{ $badgeClass }}">
                                                {{ ucfirst($tipe) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-sm font-mono font-bold text-slate-700">
                                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- FOOTER ACTIONS --}}
                <div class="bg-slate-50 px-8 py-6 border-t border-slate-100 flex flex-col md:flex-row justify-end items-center gap-3 print:hidden">
                    
                    {{-- Print Button --}}
                    <button onclick="window.print()" class="w-full md:w-auto inline-flex justify-center items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                        </svg>
                        Cetak Struk
                    </button>

                    {{-- Admin Only Actions --}}
                    @if(Auth::user()->role != 'siswa')
                        <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" 
                              class="w-full md:w-auto"
                              onsubmit="return confirm('PERINGATAN: Menghapus data pembayaran ini akan mengembalikan status tagihan siswa menjadi BELUM LUNAS. Lanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full inline-flex justify-center items-center gap-2 px-5 py-2.5 bg-rose-50 text-rose-600 font-bold rounded-xl border border-rose-100 hover:bg-rose-100 hover:text-rose-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Hapus Transaksi
                            </button>
                        </form>
                    @endif
                </div>

            </div>
            
            <div class="mt-6 text-center">
                <p class="text-xs text-slate-400">
                    Bukti pembayaran ini sah dan diterbitkan secara otomatis oleh sistem.
                </p>
            </div>

        </div>
    </div>
    <style>
    @media print {

        /* Sembunyikan semua elemen */
        body * {
            visibility: hidden !important;
        }

        /* Tampilkan hanya area invoice */
        .print-area, .print-area * {
            visibility: visible !important;
        }

        /* Posisikan agar invoice muncul di halaman print */
        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        /* Hilangkan shadow & border saat print agar rapi */
        .print-area {
            box-shadow: none !important;
            border: none !important;
        }
    }
    </style>

</x-app-layout>