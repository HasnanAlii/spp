<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Tambah Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                
                {{-- FORM HEADER --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-600 font-medium">Formulir Pendaftaran</span>
                    <a href="{{ route('siswa.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('siswa.store') }}">
                        @csrf

                        {{-- ==================================================== --}}
                        {{-- SECTION 1: BIODATA SISWA --}}
                        {{-- ==================================================== --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Biodata Siswa
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- NAMA --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="nama" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- KELAS --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                                    <input type="text" name="kelas" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('kelas') }}" placeholder="Masukkan kelas" required>
                                    @error('kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- NO TELP --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                                    <input type="tel" name="telp" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('telp') }}" placeholder="Masukan Nomor" required>
                                    @error('telp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- STATUS --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                                    <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>

                                {{-- JENIS KELAMIN --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                {{-- TANGGAL LAHIR --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('tanggal_lahir') }}">
                                </div>

                                {{-- ALAMAT --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                                    <textarea name="alamat" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                              placeholder="Alamat lengkap siswa">{{ old('alamat') }}</textarea>
                                </div>

                                {{-- TELP ORTU --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Telepon Orang Tua</label>
                                    <input type="text" name="telp_orangtua" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('telp_orangtua') }}" placeholder="Masukan Nomor">
                                </div>

                                {{-- ANGKATAN --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Angkatan</label>
                                    <input type="text" name="angkatan" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('angkatan') }}" placeholder="Tahun Masuk">
                                </div>

                            </div>
                        </div>

                        {{-- ==================================================== --}}
                        {{-- SECTION 2: AKUN LOGIN SISWA --}}
                        {{-- ==================================================== --}}
                        <div class="p-6 bg-blue-50/50 rounded-xl border border-blue-100">
                            <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Akun Login Siswa
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- NAMA AKUN --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Akun (Username)</label>
                                    <input type="text" name="name" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('name') }}" required placeholder="Masukan nama siswa">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- EMAIL --}}
                                {{-- <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('email') }}" required placeholder="email@contoh.com">
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div> --}}
                                {{-- NIS --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIS (Nomor Induk Siswa)</label>
                                    <input type="text" name="nis" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                           value="{{ old('nis') }}" required placeholder="Nomor Induk">
                                    @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- PASSWORD --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="passwordInput"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out" 
                                        placeholder="biarkan kosong">
                                         <p class="text-xs text-gray-500 mt-1">* Password default adalah password.</p>

                                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>


                            </div>
                        </div>

                        {{-- BUTTON ACTIONS --}}
                        <div class="mt-8 flex justify-end gap-3">
                            <a href="{{ route('siswa.index') }}" 
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
    <script>
    document.addEventListener('submit', function (e) {
        let pwd = document.getElementById('passwordInput');

        if (pwd.value.trim() === "") {
            pwd.value = "password"; // default
        }
    });
    </script>

</x-app-layout>