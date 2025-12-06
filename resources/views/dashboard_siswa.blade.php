<x-app-layout>
    {{-- Feather Icons --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <x-slot name="header">
        <h2 class="font-bold text-xl md:text-2xl text-green-700 leading-tight flex items-center gap-2">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12 bg-green-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- GREETING --}}
            <div class="bg-white rounded-2xl shadow-lg md:shadow-xl border border-green-100 p-6 md:p-8 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                        Hallo, 
                        <span class="text-green-600 truncate max-w-[160px] md:max-w-none">
                            {{ Auth::user()->name }}
                        </span>!
                        <span class="hidden md:inline animate-bounce">👋</span>
                    </h3>

                    <p class="text-gray-500 mt-2 text-base md:text-lg leading-relaxed">
                        Berikut informasi pembayaran dan tagihan SPP kamu.
                    </p>
                </div>

                {{-- Dekorasi (disembunyikan di mobile) --}}
                <div class="hidden md:block absolute top-0 right-0 w-40 h-40 -mr-6 -mt-6 bg-green-100 rounded-full opacity-40 blur-2xl"></div>
            </div>

            {{-- STATISTIK UNTUK SISWA --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">

                {{-- CARD: Total Tagihan --}}
                <div class="group bg-white p-5 md:p-6 rounded-2xl shadow-lg border border-red-100 hover:-translate-y-1 hover:shadow-xl transition">
                    <div class="flex items-center gap-4">
                        <div class="p-3 md:p-4 bg-red-100 text-red-600 rounded-xl group-hover:bg-red-600 group-hover:text-white">
                            <i data-feather="alert-circle" class="w-6 h-6 md:w-8 md:h-8"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 font-bold uppercase tracking-wide">Sisa Tagihan Kamu</p>
                            <p class="text-xl md:text-3xl font-extrabold text-gray-900">
                                Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Pembayaran Bulan Ini --}}
                <div class="group bg-white p-5 md:p-6 rounded-2xl shadow-lg border border-blue-100 hover:-translate-y-1 hover:shadow-xl transition">
                    <div class="flex items-center gap-4">
                        <div class="p-3 md:p-4 bg-blue-100 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white">
                            <i data-feather="calendar" class="w-6 h-6 md:w-8 md:h-8"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 font-bold uppercase tracking-wide">Pembayaran Bulan Ini</p>
                            <p class="text-xl md:text-3xl font-extrabold text-gray-900">
                                {{ $pembayaranBulanIni ? 'Sudah Bayar' : 'Belum Bayar' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Total Pembayaran --}}
                <div class="group bg-white p-5 md:p-6 rounded-2xl shadow-lg border border-green-100 hover:-translate-y-1 hover:shadow-xl transition">
                    <div class="flex items-center gap-4">
                        <div class="p-3 md:p-4 bg-green-100 text-green-600 rounded-xl group-hover:bg-green-600 group-hover:text-white">
                            <i data-feather="dollar-sign" class="w-6 h-6 md:w-8 md:h-8"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 font-bold uppercase tracking-wide">Total Sudah Dibayar</p>
                            <p class="text-xl md:text-3xl font-extrabold text-gray-900">
                                Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIWAYAT PEMBAYARAN --}}
            <div class="bg-white shadow-lg md:shadow-xl rounded-2xl overflow-hidden border border-green-100">

                {{-- Header --}}
                <div class="px-4 md:px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2 text-lg">
                        <i data-feather="list" class="w-5 h-5 text-blue-500"></i>
                        Riwayat Pembayaran Kamu
                    </h3>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-50 text-sm md:text-base">
                        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                            <tr>
                                <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-bold uppercase">Tanggal</th>
                                <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-bold uppercase">Keterangan</th>
                                <th class="px-4 md:px-6 py-3 md:py-4 text-right text-xs md:text-sm font-bold uppercase">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">

                            @forelse($riwayat as $bayar)
                                <tr class="hover:bg-green-50 transition">
                                    <td class="px-4 md:px-6 py-3 text-gray-600 whitespace-nowrap">
                                        {{ $bayar->tanggal_bayar->format('d M Y') }}
                                    </td>
                                    <td class="px-4 md:px-6 py-3 text-gray-700">
                                        {{ $bayar->keterangan ?? 'Pembayaran SPP' }}
                                    </td>
                                    <td class="px-4 md:px-6 py-3 text-right text-green-600 font-bold whitespace-nowrap">
                                        Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 md:px-6 py-10 text-center text-gray-500">
                                        <i data-feather="inbox" class="w-10 h-10 text-gray-300 mx-auto mb-2"></i>
                                        Belum ada riwayat pembayaran.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <script>feather.replace();</script>
</x-app-layout>
