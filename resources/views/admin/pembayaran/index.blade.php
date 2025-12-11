





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

            <nav class="flex text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                <span class="hover:text-blue-600 cursor-pointer transition">Dashboard</span>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Pembayaran</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-10">
        <div class="mx-auto sm:px-6 lg:px-8">

            <div class="space-y-8">

                {{-- SECTION: SUMMARY CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Card Total Pembayaran --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="absolute right-0 top-0 h-24 w-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                    <i data-feather="dollar-sign" class="h-6 w-6" aria-hidden="true"></i>
                                </div>
                                <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Pembayaran</div>
                            </div>

                            <div class="text-3xl font-extrabold text-emerald-600 font-mono tracking-tight">
                                Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Card Jumlah Transaksi --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="absolute right-0 top-0 h-24 w-24 bg-slate-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-slate-100 text-slate-700 rounded-xl">
                                    <i data-feather="list" class="h-6 w-6" aria-hidden="true"></i>
                                </div>
                                <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Jumlah Transaksi</div>
                            </div>

                            <div class="text-3xl font-extrabold text-slate-700 font-mono tracking-tight">
                                {{ $totalTransaksi ?? 0 }}
                            </div>
                        </div>
                    </div>

                    {{-- Card Rata-rata --}}
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 shadow-lg shadow-blue-500/30 text-white relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-32 w-32 bg-white/10 rounded-full -mr-8 -mt-8 blur-2xl"></div>
                        <div class="relative flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                    <i data-feather="bar-chart-2" class="h-6 w-6 text-white" aria-hidden="true"></i>
                                </div>
                                <div class="text-sm font-bold text-blue-100 uppercase tracking-wider">Rata-rata / Transaksi</div>
                            </div>

                            <div class="text-3xl font-extrabold text-white font-mono tracking-tight">
                                Rp {{ number_format(($totalTransaksi > 0 ? round(($total ?? 0) / $totalTransaksi) : 0), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION: MAIN CONTENT --}}
                <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                    <div class="p-6 lg:p-10">

                        {{-- FLASH MESSAGE --}}
                        @if(session('success'))
                            <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-between" role="status" aria-live="polite">
                                <div class="flex items-center gap-3">
                                    <i data-feather="check-circle" class="h-5 w-5" aria-hidden="true"></i>
                                    <span class="font-medium text-sm">{{ session('success') }}</span>
                                </div>
                                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600" aria-label="Tutup notifikasi">
                                    <i data-feather="x" class="w-4 h-4" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif

                        {{-- HEADER & ACTIONS --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">Riwayat Transaksi</h3>
                                <p class="text-sm text-slate-500 mt-1">Daftar lengkap transaksi pembayaran.</p>
                            </div>

                            @if(Auth::user()->role != 'siswa')
                                <a href="{{ route('pembayaran.create') }}"
                                   class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-0.5"
                                   aria-label="Tambah Transaksi">
                                    <i data-feather="plus" class="h-5 w-5 transition-transform group-hover:rotate-90" aria-hidden="true"></i>
                                    Tambah Transaksi
                                </a>
                            @endif
                        </div>

                        {{-- FILTER & EXPORT --}}
                        <div class="mb-6 overflow-x-auto pb-2">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">

                                {{-- Filter bar (left) --}}
                                @php
                                    $filters = [
                                        'harian' => 'Harian',
                                        'bulanan' => 'Bulanan',
                                        'tahunan' => 'Tahunan'
                                    ];
                                    $currentFilter = request('filter');
                                    $selectedTanggal = request('tanggal');
                                    $selectedBulan = request('bulan'); // YYYY-MM
                                    $selectedTahun = request('tahun'); // YYYY
                                @endphp

                                <div class="flex flex-wrap items-center gap-2 bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/60">
                                    <a href="{{ route('pembayaran.index') }}"
                                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 ease-in-out
                                       {{ !$currentFilter && !$selectedTanggal && !$selectedBulan && !$selectedTahun ? 'bg-white text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                                        Semua
                                    </a>

                                    @foreach($filters as $key => $label)
                                        <a href="{{ route('pembayaran.index', array_merge(request()->except('page','filter','tanggal','bulan','tahun'), ['filter' => $key])) }}"
                                           class="filter-btn px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 ease-in-out
                                           {{ ($currentFilter == $key) ? 'bg-white text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}"
                                           data-filter="{{ $key }}">
                                            {{ $label }}
                                        </a>
                                    @endforeach

                                    <form id="filter-form" action="{{ route('pembayaran.index') }}" method="GET" class="flex items-center gap-2 ml-1">
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
                                            <a href="{{ route('pembayaran.index', request()->except('page','tanggal','bulan','tahun','filter')) }}"
                                               class="px-3 py-2 rounded-xl text-xs md:text-sm font-semibold transition-all duration-200 ease-in-out text-slate-500 hover:text-slate-700 hover:bg-slate-200/50">
                                                Reset
                                            </a>
                                        @endif
                                    </form>
                                </div>

                                {{-- Export (right) --}}
                                <div class="w-full md:w-auto mt-4 md:mt-0">
                                    <a href="{{ route('pembayaran.export.pdf', array_merge([], request()->only('filter','tanggal','bulan','tahun'))) }}"
                                       class="group flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 bg-rose-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-rose-500/30 hover:bg-rose-700 hover:shadow-rose-600/40 transition-all duration-300 transform hover:-translate-y-0.5"
                                       aria-label="Export PDF">
                                        <i data-feather="download" class="h-5 w-5 transition-transform group-hover:scale-110" aria-hidden="true"></i>
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

                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @forelse($pembayarans as $pembayaran)
                                            <tr class="group hover:bg-blue-50/40 transition-colors duration-200">
                                                {{-- NO (pagination-friendly) --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                                                    {{ ($pembayarans->firstItem() ?? 0) + $loop->index }}
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
                                                        $tipe = $pembayaran->sppSiswa->tipe ?? 'lainnya';
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
                                                    {{ $pembayaran->sppSiswa->nama_spp ?? '-' }}
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
                                                               title="Detail" aria-label="Detail pembayaran">
                                                                <i data-feather="eye" class="h-5 w-5" aria-hidden="true"></i>
                                                            </a>

                                                            {{-- HAPUS --}}
                                                            <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini secara permanen?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                                        title="Hapus" aria-label="Hapus pembayaran">
                                                                    <i data-feather="trash-2" class="h-5 w-5" aria-hidden="true"></i>
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
                                                            <i data-feather="inbox" class="h-10 w-10 text-slate-300" aria-hidden="true"></i>
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
    </div>
   <script>
        (function(){
            const currentFilter = "{{ $currentFilter }}";
            const filterInput = document.getElementById('filter-input');
            const tanggal = document.getElementById('tanggal');
            const bulan = document.getElementById('bulan');
            const tahun = document.getElementById('tahun');

            function showFor(filter) {
                if (tanggal) tanggal.classList.add('hidden');
                if (bulan)   bulan.classList.add('hidden');
                if (tahun)   tahun.classList.add('hidden');

                filterInput.value = filter || '';

                if (filter === 'harian' && tanggal) {
                    tanggal.classList.remove('hidden');
                } else if (filter === 'bulanan' && bulan) {
                    bulan.classList.remove('hidden');
                } else if (filter === 'tahunan' && tahun) {
                    tahun.classList.remove('hidden');
                }
            }

            showFor(currentFilter);

            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function(e){
                    e.preventDefault();
                    const f = this.dataset.filter;
                    showFor(f);

                    document.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('bg-white','text-slate-800','shadow-sm','ring-1','ring-slate-200');
                    });

                    this.classList.add('bg-white','text-slate-800','shadow-sm','ring-1','ring-slate-200');
                    filterInput.value = f;
                });
            });
        })();
    </script>

</x-app-layout>
