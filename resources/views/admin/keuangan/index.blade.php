<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Manajemen Keuangan') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <span class="hover:text-blue-600 cursor-pointer transition">Dashboard</span>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Keuangan</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-10">
        <div class=" mx-auto sm:px-6 lg:px-8">
            
            <div class="space-y-8">
                
                {{-- SECTION: SUMMARY CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Card Pemasukan --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="absolute right-0 top-0 h-24 w-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Pemasukan</div>
                            </div>
                            <div class="text-3xl font-extrabold text-emerald-600 font-mono tracking-tight">
                                Rp {{ number_format($pemasukan, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Card Pengeluaran --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="absolute right-0 top-0 h-24 w-24 bg-rose-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-rose-100 text-rose-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6 6" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Pengeluaran</div>
                            </div>
                            <div class="text-3xl font-extrabold text-rose-600 font-mono tracking-tight">
                                Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Card Saldo --}}
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 shadow-lg shadow-blue-500/30 text-white relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-32 w-32 bg-white/10 rounded-full -mr-8 -mt-8 blur-2xl"></div>
                        <div class="relative flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-blue-100 uppercase tracking-wider">Total Dana</div>
                            </div>
                            <div class="text-3xl font-extrabold text-white font-mono tracking-tight">
                                Rp {{ number_format($saldo, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION: MAIN CONTENT --}}
                <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                    <div class="p-6 lg:p-10">
                        
                        {{-- FLASH MESSAGE --}}
                        @if(session('success'))
                            <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-between">
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

                        {{-- HEADER & ACTIONS --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">Riwayat Transaksi</h3>
                                <p class="text-sm text-slate-500 mt-1">Daftar lengkap arus kas masuk dan keluar sekolah.</p>
                            </div>
                            
                            <a href="{{ route('keuangan.create') }}" 
                               class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Transaksi
                            </a>
                        </div>

                        <div class="mb-6 overflow-x-auto pb-2">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                                
                            @php
                                $filters = [
                                    'harian' => 'Harian',
                                    'bulanan' => 'Bulanan',
                                    'tahunan' => 'Tahunan'
                                ];
                                $currentFilter = request('filter');
                                $selectedTanggal = request('tanggal');
                                $selectedBulan = request('bulan'); 
                                $selectedTahun = request('tahun'); 
                            @endphp

                            <div class="flex flex-wrap items-center gap-2 bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/60">
                                <a href="{{ route('keuangan.index') }}"
                                class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 ease-in-out
                                {{ !$currentFilter && !$selectedTanggal && !$selectedBulan && !$selectedTahun ? 'bg-white text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                                    Semua
                                </a>

                                @foreach($filters as $key => $label)
                                    <a href="{{ route('keuangan.index', array_merge(request()->except('page','filter','tanggal','bulan','tahun'), ['filter' => $key])) }}"
                                    class="filter-btn px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 ease-in-out
                                    {{ ($currentFilter == $key) ? 'bg-white text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}"
                                    data-filter="{{ $key }}">
                                        {{ $label }}
                                    </a>
                                @endforeach

                                <form id="filter-form" action="{{ route('keuangan.index') }}" method="GET" class="flex items-center gap-2 ml-1">
                                    @foreach(request()->except('page','tanggal','bulan','tahun','filter') as $name => $value)
                                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                    @endforeach

                                    <input type="hidden" name="filter" id="filter-input" value="{{ $currentFilter }}">

                                    <input id="tanggal" name="tanggal" type="date" value="{{ $selectedTanggal }}"
                                        class="date-input px-3 py-2 rounded-xl text-xs md:text-sm border border-slate-200/60 bg-white shadow-sm focus:outline-none hidden" />

                                    <input id="bulan" name="bulan" type="month" value="{{ $selectedBulan }}"
                                        class="month-input px-3 py-2 rounded-xl text-xs md:text-sm border border-slate-200/60 bg-white shadow-sm focus:outline-none hidden" />

                                    <input id="tahun" name="tahun" type="number" min="1900" max="2099" step="1" value="{{ $selectedTahun ?? date('Y') }}"
                                        class="year-input px-3 py-2 rounded-xl text-xs md:text-sm border border-slate-200/60 bg-white shadow-sm focus:outline-none hidden" />

                                    <button type="submit"
                                                class="apply-btn px-3 py-2 rounded-xl text-xs md:text-sm font-bold text-white transition-all duration-200 ease-in-out bg-blue-600 shadow-sm ring-1 ring-slate-200">
                                        Terapkan
                                    </button>

                                    @if($selectedTanggal || $selectedBulan || $selectedTahun || $currentFilter)
                                        <a href="{{ route('keuangan.index', request()->except('page','tanggal','bulan','tahun','filter')) }}"
                                        class="px-3 py-2 rounded-xl text-xs md:text-sm font-semibold transition-all duration-200 ease-in-out text-slate-500 hover:text-slate-700 hover:bg-slate-200/50">
                                            Reset
                                        </a>
                                    @endif
                                </form>
                            </div>

                            <script>
                                (function(){
                                    const currentFilter = "{{ $currentFilter }}";
                                    const filterInput = document.getElementById('filter-input');
                                    const tanggal = document.getElementById('tanggal');
                                    const bulan = document.getElementById('bulan');
                                    const tahun = document.getElementById('tahun');

                                    function showFor(filter) {
                                        tanggal.classList.add('hidden');
                                        bulan.classList.add('hidden');
                                        tahun.classList.add('hidden');

                                        filterInput.value = filter || '';

                                        if (filter === 'harian') {
                                            tanggal.classList.remove('hidden');
                                        } else if (filter === 'bulanan') {
                                            bulan.classList.remove('hidden');
                                        } else if (filter === 'tahunan') {
                                            tahun.classList.remove('hidden');
                                        } else {
                                        }
                                    }

                                    showFor(currentFilter);

                                    document.querySelectorAll('.filter-btn').forEach(btn => {
                                        btn.addEventListener('click', function(e){
                                            e.preventDefault(); 
                                            const f = this.dataset.filter;
                                            showFor(f);
                                            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('bg-white','text-slate-800','shadow-sm','ring-1','ring-slate-200'));
                                            this.classList.add('bg-white','text-slate-800','shadow-sm','ring-1','ring-slate-200');
                                            filterInput.value = f;
                                        });
                                    });

                                })();
                            </script>


                        {{-- BAGIAN KANAN: EXPORT ACTION --}}
                        <div class="w-full md:w-auto">
                            <a href="{{ route('keuangan.export.pdf', ['filter' => request('filter')]) }}"
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

                        {{-- TABLE --}}
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-100">
                                    <thead class="bg-slate-50/80">
                                        <tr>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @forelse($keuangans as $key => $keuangan)
                                        <tr class="group hover:bg-blue-50/40 transition-colors duration-200">
                                            {{-- NO --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                                                {{ $loop->iteration }}
                                            </td>
                                            
                                            {{-- TANGGAL --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-600">
                                                {{ $keuangan->created_at->format('d/m/Y') }}
                                            </td>
                                            
                                            {{-- JENIS (BADGE) --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($keuangan->arus_dana == 'masuk')
                                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                        <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                        Masuk
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                                        <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                        Keluar
                                                    </span>
                                                @endif
                                            </td>
                                            
                                            {{-- JUMLAH --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-bold font-mono tracking-tight {{ $keuangan->arus_dana == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                    {{ $keuangan->arus_dana == 'masuk' ? '+' : '-' }} Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            
                                            {{-- KETERANGAN --}}
                                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">
                                                {{ $keuangan->keterangan ?? '-' }}
                                            </td>
                                            
                                            {{-- AKSI --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center gap-2">
                                                    
                                                    {{-- DETAIL --}}
                                                    <a href="{{ route('keuangan.show', $keuangan) }}" 
                                                       class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                       title="Detail Transaksi">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>

                                                    {{-- DELETE --}}
                                                    <form action="{{ route('keuangan.destroy', $keuangan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="group p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                                title="Hapus Data">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-16 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="bg-slate-50 p-4 rounded-full mb-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <h3 class="text-lg font-semibold text-slate-700">Tidak ada transaksi ditemukan</h3>
                                                        <p class="text-sm text-slate-500 max-w-xs mx-auto mt-1">Silakan tambahkan data pemasukan atau pengeluaran baru.</p>
                                                        <a href="{{ route('keuangan.create') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                                            + Tambah Transaksi
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
                        <div class="mt-6">
                            {{ $keuangans->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>