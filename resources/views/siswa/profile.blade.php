<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Detail Siswa') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 cursor-pointer transition">
                    Dashboard
                </a>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Profil & Tagihan</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-3">
        <div class=" mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT COLUMN: PROFILE CARD --}}
                <div class="lg:col-span-1 space-y-8">
                    
                    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100 relative group">
                        {{-- Cover Background --}}
                        <div class="h-32 bg-gradient-to-br from-blue-600 to-indigo-700 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-10 -mb-10 blur-xl"></div>
                        </div>
                        
                        <div class="px-6 pb-8 relative">
                            {{-- Avatar & Status --}}
                            <div class="-mt-14 mb-5 flex justify-between items-end">
                                <div class="h-28 w-28 rounded-3xl bg-white p-1.5 shadow-lg">
                                    <div class="h-full w-full rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600 text-4xl font-extrabold border border-slate-200">
                                        {{ substr($siswa->nama, 0, 1) }}
                                    </div>
                                </div>
                                @php
                                    $statusClass = match(strtolower($siswa->status)) {
                                        'aktif' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'lulus' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide border {{ $statusClass }}">
                                    {{ $siswa->status }}
                                </span>
                            </div>

                            {{-- Nama & Info Dasar --}}
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-slate-800 leading-tight mb-1">{{ $siswa->nama }}</h3>
                                <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Kelas {{ $siswa->kelas }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Angkatan {{ $siswa->angkatan ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Detail List --}}
                            <div class="space-y-5">
                                @php
                                    $details = [
                                        ['icon' => 'phone', 'label' => 'No. Telepon', 'value' => $siswa->telp],
                                        ['icon' => 'user', 'label' => 'Jenis Kelamin', 'value' => $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'],
                                        ['icon' => 'calendar', 'label' => 'Tanggal Lahir', 'value' => $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-'],
                                        ['icon' => 'users', 'label' => 'No Orang Tua/Wali', 'value' => $siswa->telp_orangtua ?? '-'],
                                        ['icon' => 'map-pin', 'label' => 'Alamat', 'value' => $siswa->alamat ?? '-'],
                                    ];
                                @endphp

                                @foreach($details as $det)
                                <div class="flex items-start gap-4 group/item">
                                    <div class="mt-1 w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover/item:text-blue-600 group-hover/item:bg-blue-50 transition-colors flex-shrink-0">
                                        @if($det['icon'] == 'phone')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        @elseif($det['icon'] == 'user')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        @elseif($det['icon'] == 'calendar')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @elseif($det['icon'] == 'users')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-0.5">{{ $det['label'] }}</p>
                                        <p class="text-sm font-semibold text-slate-700 leading-snug">{{ $det['value'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- SUMMARY CARD --}}
                    <div class="relative overflow-hidden rounded-3xl p-8 border shadow-lg transition-all
                        {{ $totalSisa > 0 ? 'bg-rose-50 border-rose-100 shadow-rose-100/50' : 'bg-emerald-50 border-emerald-100 shadow-emerald-100/50' }}">
                        
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wide {{ $totalSisa > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    Status Keuangan Siswa
                                </h3>
                                <div class="text-4xl font-extrabold mt-2 font-mono tracking-tight {{ $totalSisa > 0 ? 'text-rose-700' : 'text-emerald-700' }}">
                                    Rp {{ number_format($totalSisa, 0, ',', '.') }}
                                </div>
                                <p class="text-sm font-medium mt-2 {{ $totalSisa > 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                                    {{ $totalSisa > 0 ? '• Total tunggakan yang harus segera dilunasi.' : '• Tidak ada tunggakan tagihan saat ini.' }}
                                </p>
                            </div>
                            
                            <div class="p-4 rounded-2xl {{ $totalSisa > 0 ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }}">
                                @if($totalSisa > 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                        </div>

                        {{-- Decoration Blob --}}
                        <div class="absolute -right-6 -top-6 w-32 h-32 rounded-full opacity-50 blur-2xl {{ $totalSisa > 0 ? 'bg-rose-200' : 'bg-emerald-200' }}"></div>
                    </div>

                    {{-- HISTORY TABLE CARD --}}
                    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl border border-slate-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Riwayat & Status Tagihan</h3>
                                <p class="text-sm text-slate-500 mt-1">Daftar lengkap kewajiban pembayaran siswa.</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
                                <thead class="bg-slate-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Tagihan</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun Ajar</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-50">
                                    @forelse($sppSiswa as $item)
                                        <tr class="group hover:bg-slate-50/60 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">{{ $item->nama_spp }}</div>
                                            </td>
                                            
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                <div class="text-xs font-medium text-slate-500 bg-slate-100 border border-slate-200 rounded-lg px-2 py-1 inline-block">
                                                    {{ $item->tahun_ajaran ?? '-' }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                @php
                                                    $tipeLabel = match($item->tipe) {
                                                        'bulanan' => 'Bulanan',
                                                        'tahunan' => 'Tahunan',
                                                        default => ucfirst($item->tipe),
                                                    };
                                                    $badgeClass = match($item->tipe) {
                                                        'bulanan' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                                        'tahunan' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                                                        default => 'bg-slate-50 text-slate-700 ring-slate-600/20',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">
                                                    {{ $tipeLabel }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-slate-600 font-medium">
                                                Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                 <span class="text-sm font-bold font-mono tracking-tight {{ $item->sisa_tagihan > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                                    Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                                 </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($item->status === 'lunas')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                        <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                        Lunas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                                        <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        Belum Lunas
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-slate-500 text-sm font-medium">Belum ada data tagihan SPP untuk siswa ini.</p>
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
        </div>
    </div>
</x-app-layout>