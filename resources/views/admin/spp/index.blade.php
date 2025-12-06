<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Tanggungan Biaya Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                
                <div class="p-6 md:p-8">
                    {{-- HEADER SECTION --}}
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Daftar SPP</h3>
                            <p class="text-sm text-gray-500">Kelola data tanggungan siswa di sini.</p>
                        </div>
                        {{-- BUTTON TAMBAH --}}
                        <a href="{{ route('spp.create') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Data
                        </a>
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div class="overflow-x-auto rounded-xl border border-blue-100">
                        <table class="min-w-full divide-y divide-blue-100">
                            {{-- TABLE HEAD --}}
                            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama SPP</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Jenis SPP</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Tahun Ajaran</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Dibuat</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            {{-- TABLE BODY --}}
                            <tbody class="bg-white divide-y divide-blue-50">
                                @forelse ($spp as $index => $item)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        
                                        {{-- NO --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        
                                        {{-- NAMA SPP --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                            {{ strtoupper($item->nama_spp) }}
                                        </td>

                                        {{-- KELAS --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                            <span class="px-3 py-1 bg-gray-100 rounded-full font-medium">
                                                {{ $item->kelas }}
                                            </span>
                                        </td>
                                        
                                        {{-- JENIS TANGGUNGAN (BADGE) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $tipeLabel = match($item->tipe) {
                                                    'bulanan' => 'UDB',
                                                    'tahunan' => 'UDT',
                                                    default => strtoupper($item->tipe),
                                                };
                                                
                                                $badgeClass = match($item->tipe) {
                                                    'bulanan' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                                    'tahunan' => 'bg-cyan-100 text-cyan-700 ring-cyan-600/20',
                                                    default => 'bg-gray-100 text-gray-700 ring-gray-600/20',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">
                                                {{ $tipeLabel }}
                                            </span>
                                        </td>
                                       
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-emerald-600 font-mono">
                                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                        </td>

                                        {{-- TAHUN AJARAN --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                            {{ $item->tahun_ajaran ?? '-' }}
                                        </td>

                                        {{-- TANGGAL --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $item->created_at->format('d/m/Y') }}
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center items-center gap-3">
                                                {{-- EDIT BUTTON --}}
                                                {{-- <a href="{{ route('spp.edit', $item->id) }}"
                                                    class="group text-blue-500 hover:text-blue-700 transition-colors"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a> --}}

                                                {{-- DELETE BUTTON --}}
                                                <form action="{{ route('spp.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada data tanggungan.</p>
                                                <p class="text-sm text-gray-400">Silakan tambahkan data baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- END TABLE CONTAINER --}}

                    {{-- PAGINATION (Opsional, jika ada) --}}
                    @if(isset($spp) && method_exists($spp, 'links'))
                        <div class="mt-4">
                            {{ $spp->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>