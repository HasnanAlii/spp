<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl leading-tight">
            {{ __('Edit Transaksi Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                {{-- FORM HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium flex items-center gap-2">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <i data-feather="edit" class="h-5 w-5"></i>
                        </div>
                        Form Edit Transaksi Keuangan
                    </span>

                    <a href="{{ route('keuangan.index') }}"
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-bold">
                        <i data-feather="arrow-left" class="h-4 w-4"></i>
                        Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('keuangan.update', $keuangan->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">

                            {{-- 1. JENIS TRANSAKSI --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                    Jenis Transaksi *
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    {{-- PEMASUKAN --}}
                                    <label class="cursor-pointer">
                                        <input type="radio"
                                               name="arus_dana"
                                               value="masuk"
                                               class="peer sr-only"
                                               {{ $keuangan->arus_dana === 'masuk' ? 'checked' : '' }}>

                                        <div class="p-4 rounded-xl border-2 flex items-center gap-3 transition-all
                                                    border-gray-200 hover:border-green-300
                                                    peer-checked:border-green-500 peer-checked:bg-green-50">

                                            <div class="p-2 rounded-lg bg-green-100 text-green-600
                                                        peer-checked:bg-green-500 peer-checked:text-white transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                </svg>
                                            </div>

                                            <div>
                                                <span class="block font-bold text-gray-700 peer-checked:text-green-800">
                                                    Pemasukan
                                                </span>
                                                <span class="block text-xs text-gray-500 peer-checked:text-green-700">
                                                    Dana masuk
                                                </span>
                                            </div>
                                        </div>
                                    </label>

                                    {{-- PENGELUARAN --}}
                                    <label class="cursor-pointer">
                                        <input type="radio"
                                               name="arus_dana"
                                               value="keluar"
                                               class="peer sr-only"
                                               {{ $keuangan->arus_dana === 'keluar' ? 'checked' : '' }}>

                                        <div class="p-4 rounded-xl border-2 flex items-center gap-3 transition-all
                                                    border-gray-200 hover:border-red-300
                                                    peer-checked:border-red-500 peer-checked:bg-red-50">

                                            <div class="p-2 rounded-lg bg-red-100 text-red-600
                                                        peer-checked:bg-red-500 peer-checked:text-white transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                                </svg>
                                            </div>

                                            <div>
                                                <span class="block font-bold text-gray-700 peer-checked:text-red-800">
                                                    Pengeluaran
                                                </span>
                                                <span class="block text-xs text-gray-500 peer-checked:text-red-700">
                                                    Dana keluar
                                                </span>
                                            </div>
                                        </div>
                                    </label>

                                </div>
                            </div>

                            {{-- 2. JUMLAH --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                    Nominal Transaksi *
                                </label>

                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <span class="text-gray-500 font-bold">Rp</span>
                                    </div>

                                    <input type="text"
                                           id="jumlah_display"
                                           class="pl-12 block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 font-bold text-lg"
                                           value="{{ number_format($keuangan->jumlah) }}"
                                           required>

                                    <input type="hidden"
                                           name="jumlah"
                                           id="jumlah"
                                           value="{{ $keuangan->jumlah }}">
                                </div>
                            </div>

                            {{-- 3. KETERANGAN --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
                                    Keterangan
                                </label>

                                <textarea name="keterangan"
                                          rows="3"
                                          class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                          placeholder="Masukan keterangan">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                            </div>

                            {{-- ACTION --}}
                            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('keuangan.index') }}"
                                   class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition">
                                    Batal
                                </a>

                                <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg
                                               hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-0.5
                                               flex items-center gap-2">
                                    <i data-feather="save" class="w-5 h-5"></i>
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
    const display = document.getElementById('jumlah_display');
    const hidden  = document.getElementById('jumlah');

    function format(x) {
        return x.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    display.addEventListener('input', () => {
        let raw = display.value.replace(/\D/g, '');
        hidden.value = raw;
        display.value = format(raw);
    });
</script>


</x-app-layout>
