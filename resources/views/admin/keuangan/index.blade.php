<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Manajemen Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100 p-6 md:p-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                        Ringkasan Keuangan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- PEMASUKAN --}}
                        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm text-emerald-600 font-bold uppercase tracking-wider">Total Pemasukan</div>
                                <div class="p-2 bg-emerald-100 rounded-full text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                            @php
                                $pemasukan = \App\Models\Keuangan::where('arus_dana', 'masuk')->sum('jumlah');
                            @endphp
                            <div class="text-2xl font-extrabold text-emerald-700">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
                        </div>

                        {{-- PENGELUARAN --}}
                        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm text-rose-600 font-bold uppercase tracking-wider">Total Pengeluaran</div>
                                <div class="p-2 bg-rose-100 rounded-full text-rose-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                    </svg>
                                </div>
                            </div>
                            @php
                                $pengeluaran = \App\Models\Keuangan::where('arus_dana', 'keluar')->sum('jumlah');
                            @endphp
                            <div class="text-2xl font-extrabold text-rose-700">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
                        </div>

                        {{-- SALDO --}}
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm text-blue-600 font-bold uppercase tracking-wider">Saldo Akhir</div>
                                <div class="p-2 bg-blue-100 rounded-full text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl font-extrabold text-blue-700">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                    <div class="p-6 md:p-8">
                        
                        {{-- FLASH MESSAGE --}}
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
                                <h3 class="text-lg font-semibold text-gray-700">Riwayat Transaksi</h3>
                                <p class="text-sm text-gray-500">Daftar lengkap arus kas masuk dan keluar.</p>
                            </div>
                            
                            {{-- BUTTON TAMBAH --}}
                            <a href="{{ route('keuangan.create') }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Transaksi
                            </a>
                        </div>

                        {{-- TABLE CONTAINER --}}
                  <div class="rounded-xl border border-blue-100 overflow-hidden">
                           <table class="min-w-full divide-y divide-blue-100">
                                {{-- TABLE HEAD --}}
                                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">No</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Keterangan</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                
                                {{-- TABLE BODY --}}
                                <tbody class="bg-white divide-y divide-blue-50">
                                    @foreach($keuangans as $key => $keuangan)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        {{-- NO --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        
                                        {{-- TANGGAL --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                            {{ $keuangan->created_at->format('d/m/Y') }}
                                        </td>
                                        
                                        {{-- JENIS (BADGE) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($keuangan->arus_dana == 'masuk')
                                                <span class="inline-flex items-center rounded-md bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                    Pemasukan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-rose-100 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                                    Pengeluaran
                                                </span>
                                            @endif
                                        </td>
                                        
                                        {{-- JUMLAH --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $keuangan->arus_dana == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $keuangan->arus_dana == 'masuk' ? '+' : '-' }} Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                                        </td>
                                        
                                        {{-- KETERANGAN --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ Str::limit($keuangan->keterangan ?? '-', 30) }}
                                        </td>
                                        
                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center items-center gap-3">
                                                
                                                {{-- DETAIL --}}
                                                <a href="{{ route('keuangan.show', $keuangan) }}" 
                                                   class="group text-teal-500 hover:text-teal-700 transition-colors"
                                                   title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>

                                                {{-- EDIT --}}
                                                {{-- <a href="{{ route('keuangan.edit', $keuangan) }}" 
                                                   class="group text-blue-500 hover:text-blue-700 transition-colors"
                                                   title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a> --}}

                                                {{-- DELETE --}}
                                                <form action="{{ route('keuangan.destroy', $keuangan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- EMPTY STATE --}}
                        @if($keuangans->isEmpty())
                            <div class="flex flex-col items-center justify-center py-10 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg font-medium">Belum ada data transaksi.</p>
                                <p class="text-sm text-gray-400">Silakan tambahkan pemasukan atau pengeluaran baru.</p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>