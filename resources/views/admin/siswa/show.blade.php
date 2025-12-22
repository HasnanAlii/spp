<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Detail Siswa') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <a href="{{ route('siswa.index') }}" class="hover:text-blue-600 transition-colors">Daftar Siswa</a>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Profil Lengkap</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI --}}
            <div class="mb-8">
                <a href="{{ route('siswa.index') }}" 
                   class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors duration-200 group">
                    <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 group-hover:border-blue-200 group-hover:bg-blue-50 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    Kembali ke Daftar Siswa
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM UTAMA (KIRI): BIODATA & SPP --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- CARD BIODATA --}}
                    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                        <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-4 bg-white">
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Informasi Pribadi</h3>
                                <p class="text-xs text-slate-500">Data diri lengkap siswa.</p>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                                <div class="group">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                                    <p class="text-base font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $siswa->nama }}</p>
                                </div>

                                <div>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
        Kelas
    </p>

    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium
                 bg-blue-50 text-blue-700 border border-blue-100">
        {{ $siswa->kelas }}
    </span>

    @if(strtolower($siswa->kelas) === 'x' || $siswa->kelas == '10')
        <div class="mt-2">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                Gelombang
            </p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium
                         bg-emerald-50 text-emerald-700 border border-emerald-100">
                Gelombang {{ $siswa->gelombang ?? '-' }}
            </span>
        </div>
    @endif
</div>

                        
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Telepon</p>
                                    <p class="text-base font-semibold text-slate-700 font-mono">{{ $siswa->telp }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Siswa</p>
                                    @php
                                        $statusClass = match(strtolower($siswa->status)) {
                                            'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'lulus' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'pindah', 'keluar' => 'bg-rose-50 text-rose-700 border-rose-100',
                                            default => 'bg-slate-50 text-slate-700 border-slate-100',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border {{ $statusClass }}">
                                        {{ $siswa->status }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                                    <p class="text-base text-slate-700 font-medium">
                                        {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Lahir</p>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <p class="text-base text-slate-700 font-medium">
                                            {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                                    <p class="text-base text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        {{ $siswa->alamat ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Telepon Orang Tua/Wali</p>
                                    <p class="text-base text-slate-700 font-mono">{{ $siswa->telp_orangtua ?? '-' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Angkatan</p>
                                    <p class="text-base text-slate-700 font-medium">{{ $siswa->angkatan ?? '-' }}</p>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- CARD DATA SPP --}}
                    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">

                        {{-- HEADER + TOTAL SISA TAGIHAN --}}
                        <div class="px-8 py-6 border-b border-slate-50 bg-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Riwayat Tagihan</h3>
                                    <p class="text-xs text-slate-500">Status pembayaran SPP & tanggungan.</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sisa Tagihan</span>
                                <span class="text-xl font-extrabold font-mono {{ $totalSisa > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    Rp {{ number_format($totalSisa, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- TABLE --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
                                <thead class="bg-slate-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama SPP</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-slate-50">
                                    @forelse($sppSiswa as $item)
                                        <tr class="hover:bg-blue-50/40 transition-colors duration-200">

                                            <td class="px-6 py-4 font-bold text-sm text-slate-700">{{ $item->nama_spp }}</td>

                                            <td class="px-6 py-4 text-center text-sm text-slate-500">
                                                <span class="bg-slate-100 px-2 py-1 rounded text-xs font-medium border border-slate-200">{{ $item->tahun_ajaran ?? '-' }}</span>
                                            </td>

                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                @php
                                            
                                                    $tipeLabel = match($item->tipe) {
                                                        'bulanan' => 'UDB',
                                                        'tahunan' => 'UDT',
                                                        default   => 'Lainnya',
                                                    };

                                                   
                                                    $badgeClass = match($item->tipe) {
                                                        'bulanan' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                                        'tahunan' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                                                        default    => 'bg-slate-50 text-slate-700 ring-slate-600/20',
                                                    };
                                                @endphp

                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold ring-1 ring-inset {{ $badgeClass }}">
                                                    {{ $tipeLabel }}
                                                </span>
                                            </td>


                                            <td class="px-6 py-4 text-right font-mono text-sm text-slate-600">
                                                Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-6 py-4 text-right font-mono text-sm font-bold {{ $item->sisa_tagihan > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                                Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-6 py-4 text-center">
                                                @if($item->status == 'lunas')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                        Lunas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        Belum
                                                    </span>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center text-slate-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">Belum ada data tanggungan.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- KOLOM SAMPING (KANAN): AKUN LOGIN --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100 sticky top-8">

                        <div class="h-20 bg-blue-600 relative">
                            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                                <div class="w-20 h-20 bg-white rounded-2xl p-1 shadow-lg">
                                    <div class="w-full h-full bg-blue-300 rounded-xl flex items-center justify-center text-white text-2xl font-bold">
                                        {{ $user ? strtoupper(substr($user->name, 0, 1)) : '?' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-12 pb-6 px-6 text-center">
                             @if ($user)
                                <h3 class="text-lg font-bold text-slate-800">{{ $user->name }}</h3>
                                <p class="text-xs font-bold text-blue-600 bg-blue-50 inline-block px-2 py-1 rounded-md mt-1 uppercase tracking-wide">Akun Siswa</p>

                                <div class="mt-6 space-y-4">
                                    {{-- <div class="flex justify-between items-center py-2 border-b border-slate-50">
                                        <span class="text-xs font-semibold text-slate-400 uppercase">Email</span>
                                        <span class="text-sm font-medium text-slate-700 truncate max-w-[150px]">{{ $user->email }}</span>
                                    </div> --}}

                                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Induk Siswa (NIS)</p>
                                        <p class="text-lg font-mono font-bold text-slate-700 tracking-wide">{{ $user->nis }}</p>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('siswa.edit', $siswa) }}" class="flex items-center justify-center w-full py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-slate-300/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit Data & Akun
                                    </a>
                                </div>

                            @else
                                <div class="py-4">
                                    <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>

                                    <p class="text-slate-600 font-medium text-sm mb-4">Siswa ini belum memiliki akun login.</p>

                                    <a href="{{ route('siswa.edit', $siswa) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold transition-colors shadow-lg shadow-blue-500/30">
                                        Buat Akun Sekarang
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>