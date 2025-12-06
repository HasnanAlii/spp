<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <a href="{{ route('pembayaran.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Transaksi
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-6">Edit Transaksi #{{ $pembayaran->id }}</h3>

                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pembayaran.update', $pembayaran) }}" id="pembayaranForm">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Pilih Siswa -->
                            <div>
                                <label for="id_siswa" class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa *</label>
                                <select name="id_siswa" id="id_siswa" 
                                        class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ old('id_siswa', $pembayaran->id_siswa) == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->nama }} - {{ $siswa->kelas }} (NISN: {{ $siswa->nisn }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jenis Pembayaran -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-4">Pilih Jenis Pembayaran *</h4>
                                
                                <!-- Bulanan -->
                                <div class="mb-6">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="toggle_bulanan" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ $pembayaran->id_bulanan ? 'checked' : '' }}>
                                        <label for="toggle_bulanan" class="ml-2 block text-sm font-medium text-gray-700">
                                            Pembayaran Bulanan
                                        </label>
                                    </div>
                                    
                                    <div id="bulanan_section" class="{{ $pembayaran->id_bulanan ? '' : 'hidden' }} pl-6 border-l-2 border-blue-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm text-gray-600 mb-1">Pilih Bulan</label>
                                                <select name="id_bulanan" id="id_bulanan" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                                                    <option value="">-- Pilih Bulan --</option>
                                                    <!-- Data bulanan akan dimuat disini -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahunan -->
                                <div class="mb-6">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="toggle_tahunan" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                            {{ $pembayaran->id_tahunan ? 'checked' : '' }}>
                                        <label for="toggle_tahunan" class="ml-2 block text-sm font-medium text-gray-700">
                                            Pembayaran Tahunan
                                        </label>
                                    </div>
                                    
                                    <div id="tahunan_section" class="{{ $pembayaran->id_tahunan ? '' : 'hidden' }} pl-6 border-l-2 border-green-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm text-gray-600 mb-1">Pilih Pembayaran Tahunan</label>
                                                <select name="id_tahunan" id="id_tahunan" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                                                    <option value="">-- Pilih Pembayaran Tahunan --</option>
                                                    <!-- Data tahunan akan dimuat disini -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lainnya -->
                                <div class="mb-6">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="toggle_lainnya" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                            {{ $pembayaran->id_pembayaran_lainnya ? 'checked' : '' }}>
                                        <label for="toggle_lainnya" class="ml-2 block text-sm font-medium text-gray-700">
                                            Pembayaran Lainnya
                                        </label>
                                    </div>
                                    
                                    <div id="lainnya_section" class="{{ $pembayaran->id_pembayaran_lainnya ? '' : 'hidden' }} pl-6 border-l-2 border-purple-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm text-gray-600 mb-1">Pilih Pembayaran Lainnya</label>
                                                <select name="id_pembayaran_lainnya" id="id_pembayaran_lainnya" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                                                    <option value="">-- Pilih Pembayaran Lainnya --</option>
                                                    <!-- Data lainnya akan dimuat disini -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div id="summary" class="{{ $pembayaran->id_bulanan || $pembayaran->id_tahunan || $pembayaran->id_pembayaran_lainnya ? '' : 'hidden' }} p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-700 mb-2">Ringkasan Pembayaran</h4>
                                <div id="summary_content" class="space-y-2">
                                    <!-- Content akan diisi oleh JavaScript -->
                                </div>
                                <div id="total_section" class="mt-3 pt-3 border-t border-gray-300">
                                    <div class="flex justify-between">
                                        <span class="font-semibold">Total:</span>
                                        <span id="total_amount" class="font-bold text-lg">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-6 border-t">
                                <a href="{{ route('pembayaran.show', $pembayaran) }}"
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition flex items-center"
                                        id="submitBtn" {{ !$pembayaran->id_bulanan && !$pembayaran->id_tahunan && !$pembayaran->id_pembayaran_lainnya ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Transaksi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data dummy untuk contoh (ganti dengan data dari controller)
        const dataBulanan = [
            {id: 1, nama_bulan: 'Januari 2024', tahun: '2024', jumlah: 500000},
            {id: 2, nama_bulan: 'Februari 2024', tahun: '2024', jumlah: 500000},
            {id: 3, nama_bulan: 'Maret 2024', tahun: '2024', jumlah: 500000},
        ];
        
        const dataTahunan = [
            {id: 1, nama_pembayaran: 'SPP Tahunan', tahun_ajaran: '2023/2024', jumlah: 3000000},
            {id: 2, nama_pembayaran: 'Uang Gedung', tahun_ajaran: '2023/2024', jumlah: 2000000},
        ];
        
        const dataLainnya = [
            {id: 1, nama_pembayaran: 'Uang Seragam', keterangan: 'Seragam Olahraga', jumlah: 250000},
            {id: 2, nama_pembayaran: 'Uang Buku', keterangan: 'Buku Paket Semester', jumlah: 150000},
        ];

        // Current selected values
        const currentBulananId = {{ $pembayaran->id_bulanan ?? 'null' }};
        const currentTahunanId = {{ $pembayaran->id_tahunan ?? 'null' }};
        const currentLainnyaId = {{ $pembayaran->id_pembayaran_lainnya ?? 'null' }};

        // Populate dropdowns with current selection
        function populateDropdowns() {
            // Bulanan
            const bulananSelect = document.getElementById('id_bulanan');
            dataBulanan.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.nama_bulan} - Rp ${item.jumlah.toLocaleString()}`;
                option.setAttribute('data-jumlah', item.jumlah);
                if (currentBulananId && item.id == currentBulananId) {
                    option.selected = true;
                }
                bulananSelect.appendChild(option);
            });

            // Tahunan
            const tahunanSelect = document.getElementById('id_tahunan');
            dataTahunan.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.nama_pembayaran} (${item.tahun_ajaran}) - Rp ${item.jumlah.toLocaleString()}`;
                option.setAttribute('data-jumlah', item.jumlah);
                if (currentTahunanId && item.id == currentTahunanId) {
                    option.selected = true;
                }
                tahunanSelect.appendChild(option);
            });

            // Lainnya
            const lainnyaSelect = document.getElementById('id_pembayaran_lainnya');
            dataLainnya.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.nama_pembayaran} - Rp ${item.jumlah.toLocaleString()}`;
                option.setAttribute('data-jumlah', item.jumlah);
                if (currentLainnyaId && item.id == currentLainnyaId) {
                    option.selected = true;
                }
                lainnyaSelect.appendChild(option);
            });
        }

        // Toggle sections
        document.getElementById('toggle_bulanan').addEventListener('change', function() {
            const section = document.getElementById('bulanan_section');
            const select = document.getElementById('id_bulanan');
            if (this.checked) {
                section.classList.remove('hidden');
                select.required = true;
            } else {
                section.classList.add('hidden');
                select.required = false;
                select.value = '';
            }
            updateSummary();
        });

        document.getElementById('toggle_tahunan').addEventListener('change', function() {
            const section = document.getElementById('tahunan_section');
            const select = document.getElementById('id_tahunan');
            if (this.checked) {
                section.classList.remove('hidden');
                select.required = true;
            } else {
                section.classList.add('hidden');
                select.required = false;
                select.value = '';
            }
            updateSummary();
        });

        document.getElementById('toggle_lainnya').addEventListener('change', function() {
            const section = document.getElementById('lainnya_section');
            const select = document.getElementById('id_pembayaran_lainnya');
            if (this.checked) {
                section.classList.remove('hidden');
                select.required = true;
            } else {
                section.classList.add('hidden');
                select.required = false;
                select.value = '';
            }
            updateSummary();
        });

        // Update summary
        function updateSummary() {
            const summary = document.getElementById('summary');
            const summaryContent = document.getElementById('summary_content');
            const totalAmount = document.getElementById('total_amount');
            const submitBtn = document.getElementById('submitBtn');
            
            let total = 0;
            let items = [];

            // Check bulanan
            const bulananSelect = document.getElementById('id_bulanan');
            if (document.getElementById('toggle_bulanan').checked && bulananSelect.value) {
                const selectedOption = bulananSelect.options[bulananSelect.selectedIndex];
                const jumlah = parseInt(selectedOption.getAttribute('data-jumlah'));
                items.push(`Bulanan: ${selectedOption.textContent}`);
                total += jumlah;
            }

            // Check tahunan
            const tahunanSelect = document.getElementById('id_tahunan');
            if (document.getElementById('toggle_tahunan').checked && tahunanSelect.value) {
                const selectedOption = tahunanSelect.options[tahunanSelect.selectedIndex];
                const jumlah = parseInt(selectedOption.getAttribute('data-jumlah'));
                items.push(`Tahunan: ${selectedOption.textContent}`);
                total += jumlah;
            }

            // Check lainnya
            const lainnyaSelect = document.getElementById('id_pembayaran_lainnya');
            if (document.getElementById('toggle_lainnya').checked && lainnyaSelect.value) {
                const selectedOption = lainnyaSelect.options[lainnyaSelect.selectedIndex];
                const jumlah = parseInt(selectedOption.getAttribute('data-jumlah'));
                items.push(`Lainnya: ${selectedOption.textContent}`);
                total += jumlah;
            }

            // Update summary content
            if (items.length > 0) {
                summary.classList.remove('hidden');
                summaryContent.innerHTML = items.map(item => 
                    `<div class="text-sm">${item}</div>`
                ).join('');
                totalAmount.textContent = `Rp ${total.toLocaleString()}`;
                submitBtn.disabled = false;
            } else {
                summary.classList.add('hidden');
                submitBtn.disabled = true;
            }
        }

        // Event listeners for select changes
        document.getElementById('id_bulanan').addEventListener('change', updateSummary);
        document.getElementById('id_tahunan').addEventListener('change', updateSummary);
        document.getElementById('id_pembayaran_lainnya').addEventListener('change', updateSummary);

        // Form validation
        document.getElementById('pembayaranForm').addEventListener('submit', function(e) {
            const idSiswa = document.getElementById('id_siswa').value;
            const hasBulanan = document.getElementById('toggle_bulanan').checked && document.getElementById('id_bulanan').value;
            const hasTahunan = document.getElementById('toggle_tahunan').checked && document.getElementById('id_tahunan').value;
            const hasLainnya = document.getElementById('toggle_lainnya').checked && document.getElementById('id_pembayaran_lainnya').value;
            
            if (!idSiswa) {
                e.preventDefault();
                alert('Harap pilih siswa');
                return false;
            }
            
            if (!hasBulanan && !hasTahunan && !hasLainnya) {
                e.preventDefault();
                alert('Harap pilih setidaknya satu jenis pembayaran');
                return false;
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            populateDropdowns();
            updateSummary();
        });
    </script>
</x-app-layout>