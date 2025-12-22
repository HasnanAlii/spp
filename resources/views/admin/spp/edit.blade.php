<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black leading-tight">
            {{ __('Edit SPP') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">

                {{-- FORM HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium">Formulir Edit SPP</span>
                    <a href="{{ route('spp.index') }}"
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                        ← Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('spp.update', $spp->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- =============================== --}}
                        {{-- TIPE TANGGUNGAN --}}
                        {{-- =============================== --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-3 text-center">
                                Pilih Jenis Tanggungan
                            </label>

                        <div class="grid grid-cols-3 gap-4">
                            @foreach ([
                                'bulanan' => ['UDB (Bulanan)', 'calendar'],
                                'tahunan' => ['UDT (Tahunan)', 'clock'],
                                'lainnya' => ['Lainnya', 'collection'],
                            ] as $key => [$label, $icon])

                                @php
                                    $isActive = $spp->tipe === $key;
                                @endphp

                                <button type="button"
                                        disabled
                                        class="py-3 px-4 rounded-xl border font-bold transition-all duration-200
                                            flex flex-col items-center justify-center gap-1
                                            cursor-not-allowed
                                            {{ $isActive
                                                    ? 'bg-blue-600 text-white border-blue-600 shadow-md ring-2 ring-blue-300'
                                                    : 'bg-gray-100 text-gray-400 border-gray-200 opacity-70' }}">

                                    {{-- ICON --}}
                                    @if($icon === 'calendar')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @elseif($icon === 'clock')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    @endif

                                    {{-- LABEL --}}
                                    <span class="text-sm text-center">
                                        {{ $label }}
                                    </span>

                                    {{-- BADGE AKTIF --}}
                                    @if($isActive)
                                        <span class="mt-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-white/20">
                                            Aktif
                                        </span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="tipe" value="{{ $spp->tipe }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- TAHUN AJARAN --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Ajaran</label>
                                <input type="text"
                                       name="tahun_ajaran"
                                       value="{{ old('tahun_ajaran', $spp->tahun_ajaran) }}"
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                            </div>

                            {{-- KELAS --}}
                        <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>

                        <select class="w-full rounded-xl border-gray-300 bg-gray-100 shadow-sm"
                                disabled>
                            @foreach ($kelasList as $kls)
                                <option value="{{ $kls }}" {{ $spp->kelas == $kls ? 'selected' : '' }}>
                                    {{ $kls }}
                                </option>
                            @endforeach
                        </select>

                        {{-- VALUE ASLI DIKIRIM --}}
                        <input type="hidden" name="kelas" value="{{ $spp->kelas }}">
                    </div>
                    <div id="gelombangWrapper"
                        class="md:col-span-2 bg-emerald-50 p-4 rounded-xl border border-emerald-200">

                        <label class="block text-sm font-semibold text-emerald-800 mb-1">
                            Gelombang Pendaftaran
                        </label>

                        <select class="w-full rounded-xl border-emerald-300 bg-gray-100 shadow-sm"
                                disabled>
                            <option value="">-- Pilih Gelombang --</option>
                            @for ($i = 1; $i <= 3; $i++)
                                <option value="{{ $i }}" {{ $spp->gelombang == $i ? 'selected' : '' }}>
                                    Gelombang {{ $i }}
                                </option>
                            @endfor
                        </select>

                        {{-- VALUE ASLI DIKIRIM --}}
                        <input type="hidden" name="gelombang" value="{{ $spp->gelombang }}">
                    </div>

                            {{-- NAMA SPP --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tanggungan</label>
                                <input type="text"
                                       name="nama_spp"
                                       value="{{ old('nama_spp', $spp->nama_spp) }}"
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Jumlah Tagihan
                                </label>

                                <div class="relative rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 font-bold">Rp</span>
                                    </div>

                                    <input type="text"
                                        id="nominalFormatted"
                                        value="{{ number_format($spp->nominal, 0, ',', '.') }}"
                                        class="w-full rounded-xl border-gray-300 pl-12 py-2.5 shadow-sm
                                                focus:border-blue-500 focus:ring-blue-500 font-semibold"
                                        placeholder="0"
                                        required>

                                    <input type="hidden"
                                        name="nominal"
                                        id="nominalReal"
                                        value="{{ $spp->nominal }}">
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <a href="{{ route('spp.index') }}"
                               class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-xl">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl">
                                Simpan Perubahan
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

            tipeBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    tipeBtns.forEach(b => b.classList.remove('bg-blue-600','text-white','ring-2'));
                    this.classList.add('bg-blue-600','text-white','ring-2');
                    tipeInput.value = this.dataset.tipe;
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipeInput = document.getElementById('tipeValue');
            const kelasInput = document.getElementById('kelasInput');
            const gelombangWrapper = document.getElementById('gelombangWrapper');
            const gelombangSelect = document.getElementById('gelombang');

            function toggleGelombang() {
                const tipe = tipeInput.value;
                const kelas = kelasInput.value.toLowerCase();

                if (tipe === 'tahunan' && (kelas === 'x' || kelas === '10')) {
                    gelombangWrapper.classList.remove('hidden');
                    gelombangSelect.required = true;
                } else {
                    gelombangWrapper.classList.add('hidden');
                    gelombangSelect.required = false;
                }
            }

            toggleGelombang();
            kelasInput.addEventListener('change', toggleGelombang);
            document.querySelectorAll('.tipeBtn').forEach(btn =>
                btn.addEventListener('click', () => setTimeout(toggleGelombang, 50))
            );
        });
    </script>

    <script>
        document.getElementById('nominalFormatted').addEventListener('input', function () {
            let raw = this.value.replace(/\D/g, '');
            document.getElementById('nominalReal').value = raw;
            this.value = new Intl.NumberFormat('id-ID').format(raw);
        });
    </script>

</x-app-layout>
