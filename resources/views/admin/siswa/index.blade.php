<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Daftar Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                <div class="p-6 md:p-8">

                    {{-- FLASH MESSAGE --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- HEADER SECTION --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Data Siswa</h3>
                            <p class="text-sm text-gray-500">Kelola informasi siswa terdaftar.</p>
                        </div>
                        
                        {{-- TOMBOL TAMBAH --}}
                        <a href="{{ route('siswa.create') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Siswa
                        </a>
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div class="overflow-x-auto rounded-xl border border-blue-100">
                        <table class="min-w-full divide-y divide-blue-100">
                            {{-- TABLE HEAD --}}
                            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">NIS</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            {{-- TABLE BODY --}}
                            <tbody class="bg-white divide-y divide-blue-50">
                                @forelse($siswas as $siswa)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    {{-- NO --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- NIS --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-mono">
                                        {{ $siswa->user->nis ?? '-' }}
                                    </td>

                                    {{-- NAMA --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                        {{ $siswa->nama }}
                                    </td>

                                    {{-- KELAS --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                        <span class="px-3 py-1 bg-gray-100 rounded-full font-medium">
                                            {{ $siswa->kelas }}
                                        </span>
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        {{-- Logika Badge Sederhana berdasarkan string status --}}
                                        @php
                                            $statusClass = match(strtolower($siswa->status)) {
                                                'aktif' => 'bg-green-100 text-green-700 ring-green-600/20',
                                                'lulus' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                                'pindah', 'keluar' => 'bg-red-100 text-red-700 ring-red-600/20',
                                                default => 'bg-gray-100 text-gray-700 ring-gray-600/20',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                            {{ ucfirst($siswa->status) }}
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center items-center gap-3">
                                            
                                            {{-- DETAIL --}}
                                            <a href="{{ route('siswa.show', $siswa) }}"
                                               class="group text-teal-500 hover:text-teal-700 transition-colors"
                                               title="Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('siswa.edit', $siswa) }}"
                                               class="group text-blue-500 hover:text-blue-700 transition-colors"
                                               title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('siswa.destroy', $siswa) }}" 
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
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
                                        <td colspan="6" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada data siswa.</p>
                                                <p class="text-sm text-gray-400">Silakan tambahkan data baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- PAGINATION (Opsional) --}}
                    @if(isset($siswas) && method_exists($siswas, 'links'))
                        <div class="mt-4">
                            {{ $siswas->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>