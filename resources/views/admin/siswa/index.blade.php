<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Daftar Siswa') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <span class="hover:text-blue-600 cursor-pointer transition">Dashboard</span>
                <span class="mx-2">/</span>
                <span class="text-blue-600">Data Siswa</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 px-10 bg-slate-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8">
            
            {{-- MAIN CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                <div class="p-6 lg:p-10">

                    {{-- FLASH MESSAGE --}}
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-between">
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

                    {{-- HEADER & ACTION --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Data Siswa Terdaftar</h3>
                            <p class="text-sm text-slate-500 mt-1">Kelola informasi siswa, kelas, dan status akademik.</p>
                        </div>
                        
                        <a href="{{ route('siswa.create') }}" 
                           class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Siswa Baru
                        </a>
                    </div>

                    {{-- FILTER & SEARCH TOOLBAR --}}
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-8">
                        <form method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
                            
                            {{-- Filter Kelas --}}
                            <div class="flex-1 md:flex-none md:w-48">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Filter Kelas</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <select name="kelas" class="pl-10 w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-slate-700 bg-white shadow-sm py-2.5 cursor-pointer">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelasList as $kelas)
                                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                                {{ $kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Search Input --}}
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Pencarian</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search"
                                           value="{{ request('search') }}"
                                           placeholder="Cari nama siswa atau NIS..."
                                           class="pl-10 w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-slate-700 bg-white shadow-sm py-2.5">
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-2">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-md hover:bg-blue-700 transition-all">
                                    Cari
                                </button>
                                
                                @if(request()->has('kelas') || request()->has('search'))
                                    <a href="{{ route('siswa.index') }}"
                                       class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-all">
                                       Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
                                {{-- TABLE HEAD --}}
                                <thead class="bg-slate-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">NIS</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>

                                {{-- TABLE BODY --}}
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse($siswas as $siswa)
                                        <tr class="group hover:bg-blue-50/40 transition-colors duration-200">
                                            
                                            {{-- NO --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- NIS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-mono tracking-wide">
                                                {{ $siswa->user->nis ?? '-' }}
                                            </td>

                                            {{-- NAMA --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">
                                                    {{ $siswa->nama }}
                                                </div>
                                            </td>

                                            {{-- KELAS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">
                                                    {{ $siswa->kelas }}
                                                </span>
                                            </td>

                                            {{-- STATUS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $statusClass = match(strtolower($siswa->status)) {
                                                        'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                        'lulus' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                        'pindah', 'keluar' => 'bg-rose-50 text-rose-700 border-rose-100',
                                                        default => 'bg-slate-50 text-slate-700 border-slate-100',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium border {{ $statusClass }}">
                                                    {{ ucfirst($siswa->status) }}
                                                </span>
                                            </td>

                                            {{-- AKSI --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center gap-2">
                                                    
                                                    {{-- DETAIL --}}
                                                    <a href="{{ route('siswa.show', $siswa) }}"
                                                       class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all"
                                                       title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>

                                                    {{-- EDIT --}}
                                                    <a href="{{ route('siswa.edit', $siswa) }}"
                                                       class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                       title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </a>

                                                    {{-- DELETE --}}
                                                    <form action="{{ route('siswa.destroy', $siswa) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="group p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                                title="Hapus">
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
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-slate-700">Tidak ada data siswa</h3>
                                                    <p class="text-sm text-slate-500 max-w-xs mx-auto mt-1">Gunakan tombol tambah untuk memasukkan siswa baru atau ubah kata kunci pencarian.</p>
                                                    <a href="{{ route('siswa.create') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                                        + Tambah Siswa Baru
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
                    @if(isset($siswas) && method_exists($siswas, 'links'))
                        <div class="mt-6">
                            {{ $siswas->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>