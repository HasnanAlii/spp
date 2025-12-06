<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Detail Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1 space-y-8">
                    
                    <div class="bg-white shadow-lg shadow-gray-200/50 rounded-2xl overflow-hidden border border-gray-100 relative">
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                        
                        <div class="px-6 pb-6 relative">
                            <div class="-mt-12 mb-4 flex justify-between items-end">
                                <div class="h-24 w-24 rounded-2xl bg-white p-1 shadow-md">
                                    <div class="h-full w-full rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-3xl font-bold border border-blue-100">
                                        {{ substr($siswa->nama, 0, 1) }}
                                    </div>
                                    </div>
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wide">
                                    {{ $siswa->status }}
                                </span>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $siswa->nama }}</h3>
                                <p class="text-gray-500 text-sm mt-1">Kelas {{ $siswa->kelas }} • Angkatan {{ $siswa->angkatan ?? '-' }}</p>
                            </div>

                            <hr class="border-gray-100 mb-6">

                            <div class="space-y-4">
                                @php
                                    $details = [
                                        ['icon' => 'phone', 'label' => 'No. Telepon', 'value' => $siswa->telp],
                                        ['icon' => 'user', 'label' => 'Jenis Kelamin', 'value' => $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'],
                                        ['icon' => 'calendar', 'label' => 'Tanggal Lahir', 'value' => $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-'],
                                        ['icon' => 'users', 'label' => 'Ortu/Wali', 'value' => $siswa->telp_orangtua ?? '-'],
                                        ['icon' => 'map-pin', 'label' => 'Alamat', 'value' => $siswa->alamat ?? '-', 'full' => true],
                                    ];
                                @endphp

                                @foreach($details as $det)
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 flex-shrink-0">
                                        @if($det['icon'] == 'phone')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        @elseif($det['icon'] == 'user')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        @elseif($det['icon'] == 'calendar')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @elseif($det['icon'] == 'users')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">{{ $det['label'] }}</p>
                                        <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $det['value'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-2xl p-6 shadow-lg shadow-gray-200/50 border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h3 class="text-gray-500 font-medium text-sm">Total Sisa Tagihan</h3>
                            <div class="text-3xl font-bold mt-1 {{ $totalSisa > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                Rp {{ number_format($totalSisa, 0, ',', '.') }}
                            </div>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $totalSisa > 0 ? 'Segera lakukan pembayaran untuk pelunasan.' : 'Tidak ada tunggakan tagihan.' }}
                            </p>
                        </div>
                        
                        {{-- @if($totalSisa > 0)
                        <button class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-rose-200 transition-all transform hover:scale-105">
                            Bayar Sekarang
                        </button>
                        @else
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        @endif --}}
                    </div>

                    <div class="bg-white shadow-lg shadow-gray-200/50 rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </span>
                                Riwayat Tagihan
                            </h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-50">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Tagihan</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tahun</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Sisa</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    @forelse($sppSiswa as $item)
                                        <tr class="hover:bg-gray-50/80 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->nama_spp }}</div>
                                            </td>
                                            
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                <div class="text-sm text-gray-500 bg-gray-100 rounded-md px-2 py-1 inline-block">
                                                    {{ $item->tahun_ajaran ?? '-' }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                @switch($item->tipe)
                                                    @case('bulanan')
                                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-700">Bulanan</span>
                                                        @break
                                                    @case('tahunan')
                                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-50 text-indigo-700">Tahunan</span>
                                                        @break
                                                    @default
                                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">{{ ucfirst($item->tipe) }}</span>
                                                @endswitch
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-600 font-medium">
                                                Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $item->sisa_tagihan > 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                                                Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($item->status === 'lunas')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                        <svg class="mr-1.5 h-2 w-2 text-emerald-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                                        Lunas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                                        <svg class="mr-1.5 h-2 w-2 text-rose-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                                        Belum Lunas
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-10 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-gray-500 text-sm font-medium">Belum ada data tagihan SPP.</p>
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