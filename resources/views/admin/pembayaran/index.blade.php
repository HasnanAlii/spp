<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            @if(Auth::user()->role == 'siswa')
                {{ __('Riwayat Pembayaran Saya') }}
            @else
                {{ __('Manajemen Pembayaran SPP') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                <div class="p-6 md:p-8">

                    {{-- ALERT --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- HEADER SECTION --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Data Pembayaran SPP</h3>
                            <p class="text-sm text-gray-500">
                                @if(Auth::user()->role == 'siswa')
                                    Berikut adalah riwayat pembayaran SPP dan tanggungan Anda.
                                @else
                                    Daftar seluruh pembayaran SPP masuk.
                                @endif
                            </p>
                        </div>

                        {{-- TOMBOL TAMBAH (HANYA ADMIN/PETUGAS) --}}
                        @if(Auth::user()->role != 'siswa')
                            <a href="{{ route('pembayaran.create') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Transaksi
                            </a>
                        @endif
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div class="overflow-x-auto rounded-xl border border-blue-100">
                        <table class="min-w-full divide-y divide-blue-100">
                            {{-- TABLE HEAD --}}
                            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">No</th>

                                    @if(Auth::user()->role != 'siswa')
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Siswa</th>
                                    @endif

                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Tanggungan</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Jumlah Bayar</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Tanggal</th>

                                    @if(Auth::user()->role != 'siswa')
                                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                    @endif
                                </tr>
                            </thead>

                            {{-- TABLE BODY --}}
                            <tbody class="bg-white divide-y divide-blue-50">
                                @forelse($pembayarans as $pembayaran)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">

                                        {{-- NO --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- NAMA SISWA (ADMIN ONLY) --}}
                                        @if(Auth::user()->role != 'siswa')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-gray-800">{{ $pembayaran->siswa->nama }}</span>
                                                    <span class="text-xs text-gray-500">Kelas: {{ $pembayaran->siswa->kelas }}</span>
                                                </div>
                                            </td>
                                        @endif

                                        {{-- JENIS PEMBAYARAN (BADGE) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $tipe = $pembayaran->sppSiswa->tipe;
                                                $label = match($tipe) {
                                                    'bulanan' => 'UDB',
                                                    'tahunan' => 'UDT',
                                                    default => 'Lainnya',
                                                };
                                                
                                                $badgeClass = match($tipe) {
                                                    'bulanan' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                                    'tahunan' => 'bg-teal-100 text-teal-700 ring-teal-600/20',
                                                    default => 'bg-purple-100 text-purple-700 ring-purple-600/20',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">
                                                {{ $label }}
                                            </span>
                                        </td>

                                        {{-- NAMA TANGGUNGAN --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $pembayaran->sppSiswa->nama_spp }}
                                        </td>

                                        {{-- NOMINAL BAYAR --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-emerald-600 font-mono">
                                            Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                        </td>

                                        {{-- TANGGAL --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d/m/Y') }}
                                        </td>

                                        {{-- AKSI (ADMIN ONLY) --}}
                                        @if(Auth::user()->role != 'siswa')
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center gap-3">
                                                    
                                                    {{-- DETAIL --}}
                                                    <a href="{{ route('pembayaran.show', $pembayaran->id) }}"
                                                        class="group text-teal-500 hover:text-teal-700 transition-colors"
                                                        title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>

                                                    {{-- EDIT --}}
                                                    {{-- <a href="{{ route('pembayaran.edit', $pembayaran->id) }}"
                                                        class="group text-blue-500 hover:text-blue-700 transition-colors"
                                                        title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </a> --}}

                                                    {{-- HAPUS --}}
                                                    <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="group text-red-400 hover:text-red-600 transition-colors"
                                                                title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
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
                                        <td colspan="{{ Auth::user()->role != 'siswa' ? 7 : 6 }}" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada riwayat transaksi.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER: TOTAL BAYAR (KHUSUS SISWA) --}}
                    @if(Auth::user()->role === 'siswa' && $pembayarans->isNotEmpty())
                        <div class="mt-6 bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl p-6 shadow-lg text-white flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-lg">Total Pembayaran Anda</h4>
                                <p class="text-blue-100 text-sm">Akumulasi seluruh pembayaran yang telah dilakukan.</p>
                            </div>
                            <div class="text-2xl font-extrabold font-mono bg-white/20 px-4 py-2 rounded-lg backdrop-blur-sm">
                                Rp {{ number_format($pembayarans->sum('jumlah_bayar'), 0, ',', '.') }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>