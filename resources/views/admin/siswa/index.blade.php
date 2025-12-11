<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Manajemen Siswa') }}
            </h2>
            <nav class="flex text-sm font-medium text-gray-500">
                <span class="hover:text-blue-600 cursor-pointer transition">Dashboard</span>
                <span class="mx-2">/</span>
                <span class="text-blue-600"> Siswa</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 px-10 bg-slate-50 min-h-screen">
        <div class=" mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                <div class="p-6 lg:p-10">

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

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Data Siswa Terdaftar</h3>
                            <p class="text-sm text-slate-500 mt-1">Kelola informasi siswa, kelas, dan status akademik.</p>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('siswa.create') }}" 
                               class="group inline-flex items-center gap-2 px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Tambah Siswa</span>
                            </a>

                            <button onclick="openImportModal()"
                                    class="group inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 hover:shadow-emerald-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-y-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg> --}}
                                 <i data-feather="upload" class="h-5 w-5 transition-transform group-hover:-translate-y-0.5"></i>
                                <span>Import Excel</span>
                            </button>
                            
                             <button onclick="openNaikModal()"
                                    class="group inline-flex items-center gap-2 px-5 py-3 bg-purple-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:bg-purple-700 hover:shadow-purple-600/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                <span>Naik Kelas</span>
                            </button>
                        </div>
                    </div>
                    <!-- MODAL NAIK KELAS -->
                    <div id="naikModal" 
                        class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                        
                        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md relative">

                            <h2 class="text-xl font-extrabold text-slate-800 mb-2">
                                Konfirmasi Naik Kelas
                            </h2>

                            <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                                Apakah Anda yakin ingin menaikkan kelas semua siswa? 
                                Proses ini <span class="font-bold text-red-600">tidak dapat dibatalkan</span>.
                            </p>

                            <form action="{{ route('siswa.naikkelas') }}" method="POST">
                                @csrf

                                <div class="flex justify-end gap-3 mt-6">
                                    
                                    <button type="button" 
                                            onclick="closeNaikModal()"
                                            class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">
                                        Batal
                                    </button>

                                    <button type="submit"
                                            class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-purple-500/30 transition">
                                        Ya, Naikkan
                                    </button>
                                </div>
                            </form>

                            <button onclick="closeNaikModal()" 
                                    class="absolute top-3 right-3 text-slate-400 hover:text-red-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>

                        </div>
                    </div>

                    <div id="importModal" 
                         class="fixed inset-0 z-50 hidden transition-opacity duration-300" 
                         aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="importModalBackdrop"></div>

                        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg scale-95 opacity-0" id="importModalPanel">
                                
                                <div class="bg-white px-6 py-6 border-b border-slate-100 flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800" id="modal-title">Import Data Siswa</h3>
                                        <p class="text-sm text-slate-500">Upload file Excel (.xlsx) sesuai format.</p>
                                    </div>
                                    <button onclick="closeImportModal()" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <form action="{{ route('siswa.import.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="px-6 py-6 space-y-4">
                                        
                                        <div class="relative group">
                                            <label for="file-upload" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/50 hover:border-blue-400 transition-all duration-300">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <div class="bg-white p-3 rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform duration-300">
                                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                    </div>
                                                    <p class="mb-1 text-sm text-slate-600 font-medium"><span class="text-blue-600 hover:underline">Klik untuk upload</span> atau drag file</p>
                                                    <p class="text-xs text-slate-400">Format yang didukung: XLSX, XLS</p>
                                                </div>
                                                <input id="file-upload" name="file" type="file" accept=".xlsx,.xls" class="hidden" required onchange="updateFileName(this)" />
                                            </label>
                                        </div>

                                        <div id="file-name-display" class="hidden items-center p-3 bg-emerald-50 border border-emerald-100 rounded-lg text-emerald-700 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="truncate font-medium" id="file-name-text"></span>
                                        </div>

                                    </div>

                                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-2 rounded-b-2xl">
                                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 transition-all">
                                            Proses Import
                                        </button>
                                        <button type="button" onclick="closeImportModal()" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        const modal = document.getElementById('importModal');
                        const backdrop = document.getElementById('importModalBackdrop');
                        const panel = document.getElementById('importModalPanel');

                        function openImportModal() {
                            modal.classList.remove('hidden');
                            setTimeout(() => {
                                backdrop.classList.remove('opacity-0');
                                panel.classList.remove('opacity-0', 'scale-95');
                                panel.classList.add('opacity-100', 'scale-100');
                            }, 10);
                        }

                        function closeImportModal() {
                            backdrop.classList.add('opacity-0');
                            panel.classList.remove('opacity-100', 'scale-100');
                            panel.classList.add('opacity-0', 'scale-95');
                            
                            setTimeout(() => {
                                modal.classList.add('hidden');
                                document.getElementById('file-upload').value = '';
                                document.getElementById('file-name-display').classList.add('hidden');
                            }, 300); 
                        }

                        function updateFileName(input) {
                            const display = document.getElementById('file-name-display');
                            const text = document.getElementById('file-name-text');
                            if (input.files && input.files[0]) {
                                text.textContent = input.files[0].name;
                                display.classList.remove('hidden');
                                display.classList.add('flex');
                            } else {
                                display.classList.add('hidden');
                                display.classList.remove('flex');
                            }
                        }
                    </script>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-8 mt-4">
                        <form method="GET" class="flex flex-col md:flex-row md:items-end gap-4">

                            <div class="flex-1 md:flex-none md:w-48">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Filter Angkatan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </div>

                                    <select name="angkatan"
                                        class="pl-10 w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-slate-700 bg-white shadow-sm py-2.5 cursor-pointer">
                                        <option value="">Semua Angkatan</option>

                                        @foreach($angkatanList as $angkatan)
                                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                                                {{ $angkatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

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

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
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

                    @if(isset($siswas) && method_exists($siswas, 'links'))
                        <div class="mt-6">
                            {{ $siswas->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
<script>
    function openNaikModal() {
        document.getElementById('naikModal').classList.remove('hidden');
    }

    function closeNaikModal() {
        document.getElementById('naikModal').classList.add('hidden');
    }
</script>

</x-app-layout>