<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black leading-tight">
            {{ __('Tambah SPP') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                {{-- FORM HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium">Formulir SPP Baru</span>
                    <a href="{{ route('spp.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('spp.store') }}">
                        @csrf

                        {{-- =============================== --}}
                        {{-- TIPE TANGGUNGAN (TABS) --}}
                        {{-- =============================== --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-3 text-center">Pilih Jenis Tanggungan</label>
                            <div class="grid grid-cols-3 gap-4">
                                <button type="button" data-tipe="bulanan"
                                    class="tipeBtn py-3 px-4 rounded-xl border border-blue-200 text-blue-600 font-bold hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    UDB (Bulanan)
                                </button>

                                <button type="button" data-tipe="tahunan"
                                    class="tipeBtn py-3 px-4 rounded-xl border border-blue-200 text-blue-600 font-bold hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    UDT (Tahunan)
                                </button>

                                <button type="button" data-tipe="lainnya"
                                    class="tipeBtn py-3 px-4 rounded-xl border border-blue-200 text-blue-600 font-bold hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Lainnya
                                </button>
                            </div>
                            {{-- Hidden Input --}}
                            <input type="hidden" name="tipe" id="tipeValue" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- TAHUN AJARAN --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" 
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    placeholder="Contoh: 2025/2026" required>
                            </div>

                            {{-- KELAS --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                              <select name="kelas"
                                    id="kelasInput"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasList as $kls)
                                    <option value="{{ $kls }}">{{ $kls }}</option>
                                @endforeach
                            </select>

                            </div>
                            {{-- GELOMBANG (KHUSUS UDT & KELAS X) --}}
                            <div id="gelombangWrapper"
                                class="hidden md:col-span-2 bg-emerald-50 p-4 rounded-xl border border-emerald-200">
                                <label class="block text-sm font-semibold text-emerald-800 mb-1">
                                    Gelombang Pendaftaran
                                </label>

                                <select name="gelombang"
                                        id="gelombang"
                                        class="w-full rounded-xl border-emerald-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150 ease-in-out">
                                    <option value="">-- Pilih Gelombang --</option>
                                    <option value="1">Gelombang 1</option>
                                    <option value="2">Gelombang 2</option>
                                    <option value="3">Gelombang 3</option>
                                </select>
                            </div>


                            {{-- NAMA SPP --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tanggungan Biaya</label>
                                <input type="text" name="nama_spp" 
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    placeholder="Contoh: SPP Bulan Januari / Uang Gedung" required>
                            </div>

                            {{-- NOMINAL --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Tagihan</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                    </div>
                                   <input type="text" id="nominalFormatted" 
                                        class="w-full rounded-xl border-gray-300 pl-10 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                        placeholder="0" required>

                                    <input type="hidden" name="nominal" id="nominalReal">

                                </div>
                            </div>

                            {{-- KETERANGAN (Hidden by default) --}}
                            <div id="lainnyaSection" class="hidden md:col-span-2 bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                                <label class="block text-sm font-semibold text-yellow-800 mb-1">Keterangan Tambahan</label>
                                <textarea name="keterangan" rows="2"
                                    class="w-full rounded-xl border-yellow-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 transition duration-150 ease-in-out bg-white"
                                    placeholder="Jelaskan detail pembayaran ini..."></textarea>
                            </div>

                        </div>

                        {{-- BUTTONS --}}
                        <div class="mt-8 flex justify-end gap-3">
                            <a href="{{ route('spp.index') }}"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition duration-300">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipeBtns = document.querySelectorAll('.tipeBtn');
            const tipeInput = document.getElementById('tipeValue');
            const lainnyaSection = document.getElementById('lainnyaSection');
            const namaSppInput = document.querySelector('input[name="nama_spp"]');

            tipeBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Reset styles for all buttons
                    tipeBtns.forEach(b => {
                        b.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'ring-2', 'ring-blue-300');
                        b.classList.add('border-blue-200', 'text-blue-600', 'hover:bg-blue-50');
                    });

                    // Set active style for clicked button
                    this.classList.remove('border-blue-200', 'text-blue-600', 'hover:bg-blue-50');
                    this.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'ring-2', 'ring-blue-300');

                    // Set hidden input value
                    const selectedTipe = this.getAttribute('data-tipe');
                    tipeInput.value = selectedTipe;

                    // Handle "Lainnya" section visibility
                    if (selectedTipe === 'lainnya') {
                        lainnyaSection.classList.remove('hidden');
                        namaSppInput.placeholder = "Contoh: Buku Paket / Seragam";
                    } else if (selectedTipe === 'bulanan') {
                        lainnyaSection.classList.add('hidden');
                        namaSppInput.placeholder = "Contoh: SPP Januari 2025";
                    } else {
                        lainnyaSection.classList.add('hidden');
                        namaSppInput.placeholder = "Contoh: Uang Gedung / Daftar Ulang";
                    }
                });
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputFormatted = document.getElementById('nominalFormatted');
        const inputReal = document.getElementById('nominalReal');

        inputFormatted.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, ""); // hanya angka
            inputReal.value = value; // simpan angka asli untuk dikirim ke server

            // Format ribuan
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipeInput        = document.getElementById('tipeValue');
        const kelasInput       = document.getElementById('kelasInput');
        const gelombangWrapper = document.getElementById('gelombangWrapper');
        const gelombangSelect  = document.getElementById('gelombang');

        function toggleGelombang() {
            const tipe  = tipeInput.value;
            const kelas = kelasInput.value.trim().toLowerCase();

            if (
                tipe === 'tahunan' &&
                (kelas === 'x' || kelas === '10')
            ) {
                gelombangWrapper.classList.remove('hidden');
                gelombangSelect.setAttribute('required', 'required');
            } else {
                gelombangWrapper.classList.add('hidden');
                gelombangSelect.removeAttribute('required');
                gelombangSelect.value = '';
            }
        }

        // 🔹 Pantau perubahan kelas
        kelasInput.addEventListener('change', toggleGelombang);
        kelasInput.addEventListener('input', toggleGelombang);

        // 🔹 Pantau perubahan tipe (klik tombol)
        document.querySelectorAll('.tipeBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                setTimeout(toggleGelombang, 50); // tunggu tipeValue terisi
            });
        });
    });
    </script>


</x-app-layout>