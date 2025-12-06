<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Tambah Pembayaran SPP') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                <div class="px-8 py-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-bold text-lg flex items-center gap-2">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        Formulir Pembayaran Baru
                    </span>

                    <a href="{{ route('pembayaran.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-bold transition-colors">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                       </svg>
                       Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">

                    {{-- ERRORALERT --}}
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <strong class="font-bold">Periksa input Anda:</strong>
                                <ul class="list-disc list-inside text-sm mt-1">
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pembayaran.store') }}">
                        @csrf

                        <div class="space-y-8">

                            <div class="border-b border-gray-100 pb-8">
                                <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                    Cari & Pilih Siswa
                                </label>

                                <select id="siswaSelect" name="siswa_id" required placeholder="Ketik nama atau NIS siswa..." autocomplete="off">
                                    <option value="">Ketik nama siswa...</option>
                                    @foreach($siswas as $s)
                                        <option value="{{ $s->id }}">
                                            {{ $s->nama }} - {{ $s->kelas }} ({{ $s->user->nis ?? 'NIS Kosong' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div id="tagihanWrapper" class="hidden pb-8 border-b border-gray-100 transition-all duration-300">
                                <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                    Pilih Tagihan SPP
                                </label>

                                <div class="relative">
                                    <select id="spp_siswa_id" name="spp_siswa_id" 
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 pl-4 pr-10 cursor-pointer transition appearance-none bg-white">
                                        <option>-- Pilih Tagihan --</option>
                                    </select>
                                    
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">* Hanya tagihan yang belum lunas yang ditampilkan.</p>
                            </div>

                            <div id="detailWrapper" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6 transition-all duration-300">
                                
                                <div class="md:col-span-2 flex items-center gap-2 mb-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                    <span class="text-sm font-bold text-gray-700">Rincian Pembayaran</span>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nominal Pembayaran</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                            <span class="text-gray-500 font-bold">Rp</span>
                                        </div>
                                        <input type="text" id="nominal_display" 
                                               class="w-full border-gray-300 rounded-xl py-3 pl-12 focus:ring-blue-500 focus:border-blue-500 font-bold text-gray-800 text-lg transition" 
                                               placeholder="0">
                                        <input type="hidden" id="nominal_bayar" name="nominal_bayar">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" 
                                           class="w-full rounded-xl border-gray-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 text-gray-700 font-medium transition">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Keterangan (Opsional)</label>
                                    <input type="text" name="keterangan" 
                                           class="w-full rounded-xl border-gray-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 text-gray-700 transition"
                                           placeholder="Masukan Keterangan jika perlu">
                                           
                                </div>
                            </div>

                            <div id="summary" class="hidden bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm transition-all duration-300">
                                <h4 class="font-bold text-blue-800 mb-4 pb-2 border-b border-blue-200 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    Ringkasan Pembayaran
                                </h4>

                                <div id="summary_content" class="text-sm text-gray-700 space-y-3"></div>

                                <div class="mt-5 pt-4 border-t border-blue-200 flex justify-between items-center">
                                    <span class="font-bold text-gray-600">Total Yang Dibayar:</span>
                                    <span id="summary_total" class="text-3xl font-extrabold text-blue-700">Rp 0</span>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('pembayaran.index') }}" 
                                   class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition duration-300">
                                    Batal
                                </a>
                                <button id="submitBtn" disabled 
                                        class="px-6 py-2.5 bg-gray-400 text-white font-bold rounded-xl shadow-none cursor-not-allowed transition-all duration-300 transform">
                                    Simpan Pembayaran
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control {
        border-radius: 0.75rem !important; /* rounded-xl */
        padding: 0.75rem 1rem !important; /* py-3 px-4 */
        border-color: #d1d5db !important; /* border-gray-300 */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        font-size: 1rem !important;
        background-color: #fff;
    }
    .ts-control:focus-within {
        border-color: #3b82f6 !important; /* ring-blue-500 */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
    }
    .ts-dropdown {
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #e5e7eb !important;
        padding: 0.5rem !important;
        margin-top: 0.5rem !important;
    }
    .ts-dropdown .option {
        border-radius: 0.5rem !important;
        padding: 0.5rem 1rem !important;
    }
    .ts-dropdown .active {
        background-color: #eff6ff !important; /* bg-blue-50 */
        color: #1d4ed8 !important; /* text-blue-700 */
        font-weight: 600;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

    new TomSelect("#siswaSelect", {
        placeholder: "Cari nama atau NIS siswa...",
        persist: false,
        create: false,
        maxOptions: 100,
        render: {
            option: function(data, escape) {
                return `<div class="py-2 px-2 border-b border-gray-50 last:border-0">${escape(data.text)}</div>`;
            },
            item: function(data, escape) {
                return `<div class="font-medium text-gray-800">${escape(data.text)}</div>`;
            }
        },
        onChange: function(value) {
            fetchTagihan(value);
        }
    });

    const dropdown        = document.getElementById("spp_siswa_id");
    const tagihanWrapper  = document.getElementById("tagihanWrapper");
    const detailWrapper   = document.getElementById("detailWrapper");
    const summary         = document.getElementById("summary");
    const content         = document.getElementById("summary_content");
    const total           = document.getElementById("summary_total");
    const submitBtn       = document.getElementById("submitBtn");
    const nominalDisplay  = document.getElementById("nominal_display");
    const nominalHidden   = document.getElementById("nominal_bayar");

    function formatRibuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function enableSubmit() {
        submitBtn.disabled = false;
        submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'shadow-none');
        submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'shadow-lg', 'hover:-translate-y-0.5');
    }

    function disableSubmit() {
        submitBtn.disabled = true;
        submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed', 'shadow-none');
        submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'shadow-lg', 'hover:-translate-y-0.5');
    }

    function fetchTagihan(siswaId) {
        tagihanWrapper.classList.add("hidden");
        detailWrapper.classList.add("hidden");
        summary.classList.add("hidden");
        disableSubmit();
        
        if (!siswaId) return;

        tagihanWrapper.classList.remove("hidden");
        dropdown.innerHTML = `<option>Sedang memuat data...</option>`;
        dropdown.disabled = true;

        fetch(`/admin/pembayaran/data/${siswaId}`)
            .then(res => res.json())
            .then(data => {
                dropdown.innerHTML = `<option value="">-- Pilih Tagihan --</option>`;
                dropdown.disabled = false;

                if (data.tagihan.length === 0) {
                    let opt = document.createElement('option');
                    opt.text = "Tidak ada tagihan tertunggak";
                    opt.disabled = true;
                    dropdown.appendChild(opt);
                } else {
                    data.tagihan.forEach(tag => {
                        let opt = document.createElement('option');
                        opt.value = tag.id;
                        opt.dataset.sisa = tag.sisa_tagihan;
                        opt.dataset.nama = tag.nama_spp;
                        opt.dataset.tipe = tag.tipe;
                        opt.innerHTML = `${tag.nama_spp} (${tag.tipe.toUpperCase()}) - Sisa: Rp ${formatRibuan(tag.sisa_tagihan)}`;
                        dropdown.appendChild(opt);
                    });
                }
            })
            .catch(err => {
                console.error(err);
                dropdown.innerHTML = `<option>Gagal memuat data (Periksa koneksi/route)</option>`;
            });
    }

    dropdown.addEventListener("change", function() {
        const opt = this.selectedOptions[0];
        
        if (!opt || !opt.value) {
            detailWrapper.classList.add("hidden");
            summary.classList.add("hidden");
            disableSubmit();
            return;
        }

        detailWrapper.classList.remove("hidden");
        summary.classList.remove("hidden");

        const sisa = opt.dataset.sisa;
        const nama = opt.dataset.nama;
        const tipe = opt.dataset.tipe;

        nominalDisplay.value = formatRibuan(sisa);
        nominalHidden.value = sisa;

        updateSummary(nama, tipe, sisa, sisa);
        
        enableSubmit();
    });

    function updateSummary(nama, tipe, sisa, bayar) {
        content.innerHTML = `
            <div class="flex justify-between"><span>Tagihan:</span> <b class="text-gray-800">${nama}</b></div>
            <div class="flex justify-between"><span>Jenis:</span> <b class="text-gray-800 uppercase">${tipe}</b></div>
            <div class="flex justify-between"><span>Sisa Kewajiban:</span> <b class="text-red-600">Rp ${formatRibuan(sisa)}</b></div>
        `;
        total.innerHTML = "Rp " + formatRibuan(bayar);
    }

    nominalDisplay.addEventListener("input", () => {
        let rawValue = nominalDisplay.value.replace(/\D/g,""); 
        
        nominalHidden.value = rawValue;
        nominalDisplay.value = formatRibuan(rawValue);

        if(dropdown.selectedOptions[0]) {
             total.innerHTML = "Rp " + formatRibuan(rawValue);
        }

        if(rawValue > 0) {
            enableSubmit();
        } else {
            disableSubmit();
        }
    });

});
</script>
