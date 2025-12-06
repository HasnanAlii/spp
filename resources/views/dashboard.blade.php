<x-app-layout>
    {{-- 1. LOAD FEATHER ICONS SCRIPT --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center gap-2">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 2. GREETING CARD --}}
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 relative overflow-hidden">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                            Halo, <span class="text-blue-600">{{ Auth::user()->name }}</span>! 
                            <span class="animate-bounce">👋</span>
                        </h3>
                        <p class="text-gray-500 mt-2 text-lg">
                            Berikut ringkasan aktivitas keuangan dan overview sistem sekolah.
                        </p>
                    </div>
                    {{-- Dekorasi Ikon Besar --}}
                    <div class="hidden md:block p-4 bg-blue-50 rounded-full text-blue-500">
                        <i data-feather="sun" class="w-10 h-10"></i>
                    </div>
                </div>
                {{-- Background Blob Decoration --}}
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-blue-100 rounded-full opacity-50 blur-2xl"></div>
            </div>

            {{-- 3. STATISTIK GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- CARD: Siswa Belum Bayar (Merah - Urgency) --}}
                <div class="group bg-white p-6 rounded-2xl shadow-lg border border-red-100 hover:-translate-y-1 hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-red-100 text-red-600 rounded-xl group-hover:bg-red-600 group-hover:text-white transition-colors">
                            <i data-feather="user-x" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-wide">Belum Bayar</p>
                            <p class="text-xl font-extrabold text-gray-900">{{ $siswaBelumBayar }}</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Pembayaran SPP Bulan Ini (Hijau - Success) --}}
                <div class="group bg-white p-6 rounded-2xl shadow-lg border border-green-100 hover:-translate-y-1 hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-green-100 text-green-600 rounded-xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <i data-feather="check-circle" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-wide">SPP dibayar bulan ini </p>
                            <p class="text-xl font-extrabold text-gray-900">
                                {{ number_format($totalPembayaranBulanIni, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Arus Dana Masuk (Biru - Income) --}}
                <div class="group bg-white p-6 rounded-2xl shadow-lg border border-blue-100 hover:-translate-y-1 hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-blue-100 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i data-feather="trending-up" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-wide">Dana Masuk</p>
                            <p class="text-xl font-extrabold text-gray-900 truncate" title="{{ number_format($arusMasuk, 0, ',', '.') }}">
                                RP. {{ \Illuminate\Support\Str::limit(number_format($arusMasuk, 0, ',', '.'), 10) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Arus Dana Keluar (Amber - Expense) --}}
                <div class="group bg-white p-6 rounded-2xl shadow-lg border border-amber-100 hover:-translate-y-1 hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-amber-100 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <i data-feather="trending-down" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-wide">Dana Keluar</p>
                            <p class="text-xl font-extrabold text-gray-900 truncate" title="{{ number_format($arusKeluar, 0, ',', '.') }}">
                                 RP. {{ \Illuminate\Support\Str::limit(number_format($arusKeluar, 0, ',', '.'), 10) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. TABEL RIWAYAT TERBARU --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                
                {{-- Header Tabel --}}
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2 text-lg">
                        <i data-feather="activity" class="w-5 h-5 text-blue-500"></i>
                        Aktivitas Keuangan Terbaru
                    </h3>
                    <a href="{{ route('keuangan.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua <i data-feather="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-50">
                        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @php
                                $logs = \App\Models\Keuangan::latest()->take(5)->get();
                            @endphp

                            @forelse($logs as $log)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i>
                                        {{ $log->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($log->arus_dana == 'masuk')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                <i data-feather="arrow-down-left" class="w-3 h-3"></i> Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                <i data-feather="arrow-up-right" class="w-3 h-3"></i> Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ Str::limit($log->keterangan ?? '-', 40) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-sm {{ $log->arus_dana == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $log->arus_dana == 'masuk' ? '+' : '-' }} 
                                        Rp {{ number_format($log->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 flex flex-col items-center justify-center">
                                        <i data-feather="inbox" class="w-10 h-10 text-gray-300 mb-2"></i>
                                        Belum ada data transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- 5. INITIALIZE FEATHER ICONS --}}
    <script>
        feather.replace();
    </script>
</x-app-layout>