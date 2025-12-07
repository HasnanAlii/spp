<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                @if(Auth::user()->role == 'siswa')
                    {{ __('Riwayat Pembayaran Saya') }}
                @else
                    {{ __('Manajemen Pembayaran') }}
                @endif
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <span class="hover:text-blue-600 cursor-pointer transition">Dashboard</span>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Pembayaran</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-10">
        <div class=" mx-auto sm:px-6 lg:px-8">
            
            {{-- MAIN CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                <div class="p-6 lg:p-10">

                    {{-- FLASH MESSAGE --}}
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium text-sm">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif

                    {{-- HEADER & ACTION --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Data Transaksi Pembayaran</h3>
                            <p class="text-sm text-slate-500 mt-1">
                                @if(Auth::user()->role == 'siswa')
                                    Pantau riwayat pembayaran SPP dan tanggungan Anda.
                                @else
                                    Daftar lengkap pembayaran SPP yang masuk dari siswa.
                                @endif
                            </p>
                        </div>

                        {{-- TOMBOL TAMBAH (HANYA ADMIN/PETUGAS) --}}
                        @if(Auth::user()->role != 'siswa')
                            <a href="{{ route('pembayaran.create') }}"
                                class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Transaksi
                            </a>
                        @endif
                    </div>

                    {{-- FILTER TABS --}}
                    <div class="mb-8 overflow-x-auto pb-2">
                      <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                         <div class="flex flex-wrap items-center gap-2 bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/60 w-full md:w-auto">
                        @php
                            $filters = [
                                'harian' => 'Hari Ini',
                                'bulanan' => 'Bulan Ini',
                                'tahunan' => 'Tahun Ini'
                            ];
                            $currentFilter = request('filter');
                        @endphp

                        {{-- Tombol Semua --}}
                        <a href="{{ route('pembayaran.index') }}"
                        class="flex-1 md:flex-none text-center px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 ease-in-out
                        {{ !$currentFilter ? 'bg-white text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                            Semua
                        </a>

                        {{-- Loop Filter --}}
                        @foreach($filters as $key => $label)
                            <a href="{{ route('pembayaran.index', ['filter' => $key]) }}"
                            class="flex-1 md:flex-none text-center px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 ease-in-out
                            {{ $currentFilter == $key ? 'bg-white text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    {{-- BAGIAN KANAN: EXPORT ACTION --}}
                    <div class="w-full md:w-auto">
                        <a href="{{ route('pembayaran.export.pdf', ['filter' => request('filter')]) }}"
                        class="group flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 bg-rose-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-rose-500/30 hover:bg-rose-700 hover:shadow-rose-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                            
                            {{-- Icon PDF / Download --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            
                            <span>Export PDF</span>
                        </a>
                    </div>
                </div>
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
                                {{-- TABLE HEAD --}}
                                <thead class="bg-slate-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>

                                        @if(Auth::user()->role != 'siswa')
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                                        @endif

                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Tanggungan</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Bayar</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>

                                        @if(Auth::user()->role != 'siswa')
                                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>

                                {{-- TABLE BODY --}}
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse($pembayarans as $pembayaran)
                                        <tr class="group hover:bg-blue-50/40 transition-colors duration-200">

                                            {{-- NO --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- NAMA SISWA (ADMIN ONLY) --}}
                                            @if(Auth::user()->role != 'siswa')
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">{{ $pembayaran->siswa->nama }}</span>
                                                        <span class="text-xs text-slate-400">Kelas: {{ $pembayaran->siswa->kelas }}</span>
                                                    </div>
                                                </td>
                                            @endif

                                            {{-- JENIS PEMBAYARAN (BADGE) --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $tipe = $pembayaran->sppSiswa->tipe;
                                                    $label = match($tipe) {
                                                        'bulanan' => 'Bulanan',
                                                        'tahunan' => 'Tahunan',
                                                        default => ucfirst($tipe),
                                                    };
                                                    
                                                    $badgeClass = match($tipe) {
                                                        'bulanan' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                        'tahunan' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                                        default => 'bg-slate-50 text-slate-700 border-slate-100',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium border {{ $badgeClass }}">
                                                    {{ $label }}
                                                </span>
                                            </td>

                                            {{-- NAMA TANGGUNGAN --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                                {{ $pembayaran->sppSiswa->nama_spp }}
                                            </td>

                                            {{-- NOMINAL BAYAR --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-bold text-emerald-600 font-mono tracking-tight bg-emerald-50 px-2 py-1 rounded-md">
                                                    Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                                </span>
                                            </td>

                                            {{-- TANGGAL --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-500">
                                                {{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d/m/Y') }}
                                            </td>

                                            {{-- AKSI (ADMIN ONLY) --}}
                                            @if(Auth::user()->role != 'siswa')
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="flex justify-center items-center gap-2">
                                                        
                                                        {{-- DETAIL --}}
                                                        <a href="{{ route('pembayaran.show', $pembayaran->id) }}"
                                                            class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all"
                                                            title="Detail">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </a>

                                                        {{-- HAPUS --}}
                                                        <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini secara permanen?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                                    title="Hapus">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ Auth::user()->role != 'siswa' ? 7 : 6 }}" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="bg-slate-50 p-4 rounded-full mb-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-slate-700">Belum ada riwayat transaksi</h3>
                                                    <p class="text-sm text-slate-500 max-w-xs mx-auto mt-1">Data pembayaran akan muncul di sini setelah transaksi dilakukan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-6">
                        {{ $pembayarans->links() }}
                    </div>

                    {{-- FOOTER: TOTAL BAYAR (KHUSUS SISWA) --}}
                    @if(Auth::user()->role === 'siswa' && $pembayarans->isNotEmpty())
                        <div class="mt-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 shadow-lg shadow-blue-500/30 text-white flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
                            <div class="absolute right-0 top-0 h-32 w-32 bg-white/10 rounded-full -mr-8 -mt-8 blur-2xl"></div>
                            <div class="relative z-10 mb-4 md:mb-0">
                                <h4 class="font-bold text-xl">Total Pembayaran Anda</h4>
                                <p class="text-blue-100 text-sm mt-1 opacity-90">Akumulasi seluruh pembayaran yang telah berhasil dilakukan.</p>
                            </div>
                            <div class="relative z-10 text-3xl font-extrabold font-mono bg-white/10 border border-white/20 px-6 py-3 rounded-xl backdrop-blur-sm">
                                Rp {{ number_format($pembayarans->sum('jumlah_bayar'), 0, ',', '.') }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>