<x-app-layout>
  <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Ringkasan aktivitas keuangan sekolah</p>
            </div>

            <form method="GET" class="relative z-20">
                <div class="flex items-center bg-white p-1.5 rounded-full border border-slate-200 shadow-sm shadow-slate-200/50 hover:shadow-md hover:border-blue-200 transition-all duration-300">
                    
                    <div class="relative group border-r border-slate-100 pr-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <select name="month" 
                            class="appearance-none bg-transparent border-none py-2 pl-9 pr-8 text-sm font-semibold text-slate-600 hover:text-blue-600 focus:ring-0 cursor-pointer outline-none transition-colors w-32 md:w-40">
                            @foreach($months as $key => $label)
                                <option value="{{ $key }}" {{ (int)$selectedMonth === (int)$key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    
                    </div>

                    <div class="relative group pl-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <select name="year" 
                            class="appearance-none bg-transparent border-none py-2 pl-9 pr-8 text-sm font-semibold text-slate-600 hover:text-blue-600 focus:ring-0 cursor-pointer outline-none transition-colors w-24 md:w-28">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ (int)$selectedYear === (int)$year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                     
                    </div>

                    <button type="submit" class="ml-2 p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-md hover:shadow-lg transition-all transform active:scale-95 flex items-center gap-2 px-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span class="text-xs font-bold">Filter</span>
                    </button>
                    
                    @if(request()->has('month') || request()->has('year'))
                        <a href="{{ route('dashboard') }}" 
                           title="Reset Filter"
                           class="ml-2 p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif

                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-10">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-8">
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
                    <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-2xl text-sm font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Data untuk {{ $months[$selectedMonth] }} {{ $selectedYear }}
                    </div>

                </div>

                {{-- Decoration --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full opacity-50 blur-3xl pointer-events-none"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-red-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">

                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-red-100 text-red-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tunggakan SPP</p>
                        </div>

                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-extrabold text-slate-800">{{ $siswaBelumBayar }}</p>
                            <p class="text-sm text-slate-400 font-medium">Siswa</p>
                        </div>

                        <p class="text-sm font-semibold text-red-600 mt-2">
                            Total Sisa: Rp {{ number_format($totalSisaTunggakan, 0, ',', '.') }}
                        </p>

                    </div>
                </div>


                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-emerald-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pembayaran SPP </p>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-extrabold text-slate-800">{{ $totalPembayaranBulanIni }}</p>
                            <p class="text-sm text-slate-400 font-medium">Pembayaran</p>
                        </div>
                         <p class="text-sm font-semibold text-green-600 mt-2">
                            Total Pembayaran : Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                        </p>

                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dana Masuk</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight truncate"
                        title="{{ number_format($arusMasuk, 0, ',', '.') }}">
                            Rp {{ number_format($arusMasuk, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-amber-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-amber-100 text-amber-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dana Keluar</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight truncate"
                        title="{{ number_format($arusKeluar, 0, ',', '.') }}">
                            Rp {{ number_format($arusKeluar, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

            </div>



            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="font-bold text-xl text-slate-800">Aktivitas Keuangan Terbaru</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            5 transaksi terakhir bulan {{ $months[$selectedMonth] }} {{ $selectedYear }}.
                        </p>
                    </div>

                    <a href="{{ route('keuangan.index') }}" 
                       class="group flex items-center gap-1 text-sm text-blue-600 font-semibold hover:text-blue-700 transition">
                        Lihat Semua
                        <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

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
                            @forelse($logs as $log)
                                <tr class="hover:bg-blue-50/40 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                        {{ $log->created_at->format('d M Y') }}
                                        <span class="text-xs text-slate-400 ml-1">({{ $log->created_at->format('H:i') }})</span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($log->arus_dana === 'masuk')
                                            <span class="badge-green">Masuk</span>
                                        @else
                                            <span class="badge-red">Keluar</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">
                                        {{ $log->keterangan ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-right font-bold font-mono tracking-tight 
                                        {{ $log->arus_dana === 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $log->arus_dana === 'masuk' ? '+' : '-' }} 
                                        Rp {{ number_format($log->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center text-slate-500">
                                        Tidak ada transaksi.
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