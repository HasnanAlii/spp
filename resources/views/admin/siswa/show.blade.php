<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Detail Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI --}}
            <div class="mb-6">
                <a href="{{ route('siswa.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar Siswa
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: BIODATA --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- CARD BIODATA --}}
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-blue-50/50 flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Informasi Pribadi</h3>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Nama Lengkap</p>
                                    <p class="text-base font-bold text-gray-800">{{ $siswa->nama }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Kelas</p>
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">
                                        {{ $siswa->kelas }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Nomor Telepon</p>
                                    <p class="text-base font-semibold text-gray-800">{{ $siswa->telp }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Status Siswa</p>
                                    @if(strtolower($siswa->status) == 'aktif')
                                        <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded text-sm">Aktif</span>
                                    @else
                                        <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded text-sm">{{ ucfirst($siswa->status) }}</span>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</p>
                                    <p class="text-base text-gray-800">
                                        {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</p>
                                    <p class="text-base text-gray-800">
                                        {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Alamat</p>
                                    <p class="text-base text-gray-800 leading-relaxed">{{ $siswa->alamat ?? '-' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Telepon Orang Tua</p>
                                    <p class="text-base text-gray-800">{{ $siswa->telp_orangtua ?? '-' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Angkatan</p>
                                    <p class="text-base text-gray-800">{{ $siswa->angkatan ?? '-' }}</p>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- CARD DATA SPP --}}
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                        {{-- HEADER + TOTAL SISA TAGIHAN --}}
                        <div class="px-6 py-4 border-b border-blue-200 bg-blue-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Riwayat SPP & Tanggungan
                            </h3>

                            <div>
                                <span class="text-sm font-medium text-gray-500 mr-2">Total Sisa:</span>
                                <span class="text-xl font-extrabold {{ $totalSisa > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    Rp {{ number_format($totalSisa, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- TABLE --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-blue-100">
                                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama SPP</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Tahun</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Tipe</th>
                                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider">Total</th>
                                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider">Sisa</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-blue-50">
                                    @forelse($sppSiswa as $item)
                                        <tr class="hover:bg-blue-50 transition-colors">

                                            <td class="px-4 py-3 font-medium text-gray-800">{{ $item->nama_spp }}</td>

                                            <td class="px-4 py-3 text-center text-gray-600">
                                                {{ $item->tahun_ajaran ?? '-' }}
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                @if($item->tipe === 'bulanan')
                                                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded">Bulanan</span>
                                                @elseif($item->tipe === 'tahunan')
                                                    <span class="text-xs font-semibold text-teal-600 bg-teal-100 px-2 py-1 rounded">Tahunan</span>
                                                @else
                                                    <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ ucfirst($item->tipe) }}</span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-3 text-right font-mono text-gray-700">
                                                Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-4 py-3 text-right font-mono font-bold {{ $item->sisa_tagihan > 0 ? 'text-red-500' : 'text-green-500' }}">
                                                Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                @if($item->status == 'lunas')
                                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Lunas</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Belum Lunas</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                                Belum ada data tanggungan SPP.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN: AKUN LOGIN --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100 sticky top-6">

                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                            <div class="p-2 bg-gray-200 rounded-lg text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Akun Login</h3>
                        </div>

                        <div class="p-6">

                            @if ($user)
                                <div class="space-y-4">
                                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 text-center">
                                        <div class="w-16 h-16 bg-blue-200 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <p class="font-bold text-gray-800 text-lg">{{ $user->name }}</p>

                                        <span class="inline-block mt-1 px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full uppercase tracking-wider">
                                            Siswa
                                        </span>
                                    </div>

                                    <div class="space-y-3 pt-2">
                                        {{-- <div>
                                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Email</p>
                                            <p class="text-gray-700 font-medium break-all">{{ $user->email }}</p>
                                        </div> --}}

                                        <div>
                                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">NIS</p>
                                            <p class="text-gray-700 font-medium font-mono tracking-wide">{{ $user->nis }}</p>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-gray-100">
                                        <a href="{{ route('siswa.edit', $siswa) }}" class="block w-full text-center py-2 bg-yellow-100 text-yellow-700 font-bold rounded-lg hover:bg-yellow-200 transition-colors">
                                            Edit Data & Akun
                                        </a>
                                    </div>
                                </div>

                            @else
                                <div class="text-center py-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>

                                    <p class="text-red-600 font-medium mb-4">Akun login tidak ditemukan.</p>

                                    <a href="{{ route('siswa.edit', $siswa) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
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
