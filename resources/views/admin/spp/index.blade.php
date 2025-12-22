<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Manajemen SPP') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <span class="hover:text-blue-600 cursor-pointer transition">Dashboard</span>
                <span class="mx-2">/</span>
                <span class="text-blue-600">SPP</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-10">
        <div class=" mx-auto sm:px-6 lg:px-8">

            {{-- MAIN CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                
                <div class="p-6 lg:p-10">
                    
                    {{-- HEADER & ACTION --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Daftar Tagihan SPP</h3>
                            <p class="text-sm text-slate-500 mt-1">Kelola data tanggungan dan tagihan siswa.</p>
                        </div>
                        
                        <a href="{{ route('spp.create') }}"
                            class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Buat Tagihan Baru
                        </a>
                    </div>

                    {{-- FILTER TOOLBAR --}}
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-8">
                        <form method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
                            
                            {{-- Filter Bulan --}}
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Bulan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <select name="bulan" class="pl-10 w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-slate-700 bg-white shadow-sm py-2.5 cursor-pointer">
                                        <option value="">Semua Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            {{-- Filter Tahun --}}
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Tahun</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <select name="tahun" class="pl-10 w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-slate-700 bg-white shadow-sm py-2.5 cursor-pointer">
                                        <option value="">Semua Tahun</option>
                                        @for ($t = 2030; $t >= 2020; $t--)
                                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                                {{ $t }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="flex gap-2">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-md hover:bg-slate-900 transition-all">
                                    Filter Data
                                </button>
                                <a href="{{ route('spp.index') }}"
                                   class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-all">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
                                {{-- TABLE HEAD --}}
                                <thead class="bg-slate-50/80">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Tagihan</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun Ajar</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>

                                {{-- TABLE BODY --}}
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse ($spp as $index => $item)
                                        <tr class="group hover:bg-blue-50/40 transition-colors duration-200">
                                            
                                            {{-- NO --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                                                {{ $index + 1 }}
                                            </td>
                                            
                                            {{-- NAMA SPP --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">
                                                    {{ strtoupper($item->nama_spp) }}
                                                </div>
                                                <div class="text-xs text-slate-400 mt-0.5">
                                                    Dibuat: {{ $item->created_at->format('d M Y') }}
                                                </div>
                                            </td>

                                            {{-- KELAS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">
                                                    {{ $item->kelas }}
                                                </span>
                                            </td>
                                            
                                            {{-- JENIS (BADGE) --}}
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

                                           
                                            {{-- NOMINAL --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-bold text-emerald-600 font-mono tracking-tight bg-emerald-50 px-2 py-1 rounded-md">
                                                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                                </span>
                                            </td>

                                            {{-- TAHUN AJARAN --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500 font-medium">
                                                {{ $item->tahun_ajaran ?? '-' }}
                                            </td>

                                            {{-- AKSI --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center gap-2">
                                                    {{-- EDIT (Opsional - Icon Only) --}}
                                                        {{-- <a href="{{ route('spp.edit', $item->id) }}"
                                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                            title="Edit">
                                                            <i data-feather="edit" class="h-5 w-5" aria-hidden="true"></i>
                                                        </a> --}}

                                                    {{-- DELETE --}}
                                                    <form action="{{ route('spp.destroy', $item->id) }}" method="POST"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tagihan ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="group p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                            title="Hapus Data">
                                                            <i data-feather="trash-2" class="h-5 w-5" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="bg-slate-50 p-4 rounded-full mb-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-slate-700">Tidak ada data ditemukan</h3>
                                                    <p class="text-sm text-slate-500 max-w-xs mx-auto mt-1">Silakan sesuaikan filter Anda atau tambahkan data tagihan baru.</p>
                                                    <a href="{{ route('spp.create') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                                        + Tambah Data Baru
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- PAGINATION --}}
                    @if(isset($spp) && method_exists($spp, 'links'))
                        <div class="mt-6">
                            {{ $spp->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>