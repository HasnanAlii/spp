<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Dashboard Admin') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <span class="text-blue-600 cursor-default">Overview</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-10">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. GREETING CARD --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">
                            Selamat Datang, <span class="text-blue-600">{{ Auth::user()->name }}</span>! 
                            <span class="inline-block hover:animate-spin cursor-default">👋</span>
                        </h3>
                        <p class="text-slate-500 mt-2 text-lg">
                            Berikut adalah ringkasan aktivitas keuangan dan status siswa sekolah Anda hari ini.
                        </p>
                    </div>
                    
                    {{-- Date Badge --}}
                    <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-2xl text-sm font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                {{-- Decoration --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full opacity-50 blur-3xl pointer-events-none"></div>
            </div>

            {{-- 2. STATISTIK GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- CARD: Siswa Belum Bayar --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-red-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-red-100 text-red-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tunggakan SPP</p>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-extrabold text-slate-800">{{ $siswaBelumBayar }}</p>
                            <p class="text-sm text-slate-400 font-medium">Siswa</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Pembayaran Bulan Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-emerald-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">SPP Lunas (Bulan Ini)</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight">
                            Rp {{ number_format($totalPembayaranBulanIni, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- CARD: Arus Masuk --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dana Masuk</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight truncate" title="{{ number_format($arusMasuk, 0, ',', '.') }}">
                            Rp {{ number_format($arusMasuk, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- CARD: Arus Keluar --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-amber-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-amber-100 text-amber-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dana Keluar</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight truncate" title="{{ number_format($arusKeluar, 0, ',', '.') }}">
                            Rp {{ number_format($arusKeluar, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 3. TABEL RIWAYAT TERBARU --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                
                {{-- Header Tabel --}}
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="font-bold text-xl text-slate-800">Aktivitas Keuangan Terbaru</h3>
                        <p class="text-sm text-slate-500 mt-1">5 transaksi terakhir yang tercatat dalam sistem.</p>
                    </div>
                    <a href="{{ route('keuangan.index') }}" class="group flex items-center gap-1 text-sm text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                        Lihat Semua 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @php
                                $logs = \App\Models\Keuangan::latest()->take(5)->get();
                            @endphp

                            @forelse($logs as $log)
                                <tr class="hover:bg-blue-50/40 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                        {{ $log->created_at->format('d M Y') }}
                                        <span class="text-xs text-slate-400 ml-1">({{ $log->created_at->format('H:i') }})</span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($log->arus_dana == 'masuk')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 max-w-xs truncate">
                                        {{ $log->keterangan ?? '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-sm font-mono tracking-tight {{ $log->arus_dana == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $log->arus_dana == 'masuk' ? '+' : '-' }} 
                                        Rp {{ number_format($log->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-500">
                                            <div class="bg-slate-50 p-3 rounded-full mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium">Belum ada aktivitas transaksi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>