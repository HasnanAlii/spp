<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl leading-tight">
            {{ __('Edit Pembayaran SPP') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                {{-- HEADER --}}
                <div class="px-8 py-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                      <span class="text-gray-600 font-bold text-lg flex items-center gap-2">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        Formulir Edit Pembayaran 
                    </span>

                    <a href="{{ route('pembayaran.index') }}"
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-bold">
                       ← Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">

                    {{-- ERROR --}}
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pembayaran.update', $pembayaran->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">

                            {{-- SISWA --}}
                            <div class="border-b pb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Siswa
                                </label>
                                <input type="text"
                                       class="w-full rounded-xl border-gray-300 bg-gray-100 py-3 px-4 font-semibold"
                                       value="{{ $pembayaran->siswa->nama }} - {{ $pembayaran->siswa->kelas }}"
                                       readonly>
                            </div>

                            {{-- TAGIHAN --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Pilih Tagihan SPP
                                </label>

                                <select name="spp_siswa_id"
                                        id="spp_siswa_id"
                                        class="w-full rounded-xl border-gray-300 py-3 px-4">
                                    @foreach($tagihans as $tagihan)
                                        <option value="{{ $tagihan->id }}"
                                            data-sisa="{{ $tagihan->sisa_tagihan }}"
                                            {{ $tagihan->id == $pembayaran->spp_siswa_id ? 'selected' : '' }}>
                                            {{ $tagihan->nama_spp }} – Sisa:
                                            Rp {{ number_format($tagihan->sisa_tagihan) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- DETAIL --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                        Nominal Pembayaran
                                    </label>

                                    <div class="relative">
                                        <span class="absolute left-4 top-3 font-bold text-gray-500">Rp</span>
                                        <input type="text"
                                               id="nominal_display"
                                               class="w-full rounded-xl border-gray-300 py-3 pl-12 font-bold text-lg"
                                               value="{{ number_format($pembayaran->jumlah_bayar) }}">
                                        <input type="hidden"
                                               name="nominal_bayar"
                                               id="nominal_bayar"
                                               value="{{ $pembayaran->jumlah_bayar }}">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                        Tanggal Transaksi
                                    </label>
                                    <input type="date"
                                           name="tanggal_bayar"
                                           value="{{ $pembayaran->tanggal_bayar->format('Y-m-d') }}"
                                           class="w-full rounded-xl border-gray-300 py-3 px-4">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                        Keterangan
                                    </label>
                                    <input type="text"
                                           name="keterangan"
                                           value="{{ $pembayaran->keterangan }}"
                                           class="w-full rounded-xl border-gray-300 py-3 px-4">
                                </div>
                            </div>

                            {{-- SUBMIT --}}
                            <div class="flex justify-end gap-3 pt-6 border-t">
                                <a href="{{ route('pembayaran.index') }}"
                                   class="px-5 py-2.5 bg-gray-200 rounded-xl font-semibold">
                                    Batal
                                </a>

                                <button type="submit"
                                        class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg">
                                    Update Pembayaran
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
const display = document.getElementById('nominal_display');
const hidden  = document.getElementById('nominal_bayar');

function format(x) {
    return x.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

display.addEventListener('input', () => {
    let raw = display.value.replace(/\D/g, '');
    hidden.value = raw;
    display.value = format(raw);
});
</script>
