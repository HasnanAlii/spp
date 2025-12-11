<x-app-layout>
    {{-- LOAD FEATHER ICONS --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center gap-2">
            <i data-feather="user" class="w-6 h-6"></i>
            {{ __('Edit Profil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ALERT SUKSES --}}
            @if (session('status') === 'profile-updated' || session('status') === 'siswa-updated')
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
                    <i data-feather="check-circle" class="w-5 h-5"></i>
                    <span>Data berhasil diperbarui.</span>
                </div>
            @endif

   
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center gap-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <i data-feather="lock" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">Informasi Akun</h3>
                </div>

                <div class="p-6 md:p-8">
                  <form method="POST" action="{{ route('profile.update.akun') }}">

                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Nama Akun --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Akun / Username</label>
                                <input type="text" name="name" 
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                       value="{{ old('name', $user->name) }}" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- NIS --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" 
                                       class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100"
                                       value="{{ old('nis', $user->nis) }}" disabled />
                                <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                <input type="password" name="password" 
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                       placeholder="Kosongkan jika tidak diganti" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-200 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i data-feather="save" class="w-4 h-4"></i>
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>

    
            @hasrole('siswa')
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-blue-100">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center gap-2">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                        <i data-feather="user" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">Biodata Lengkap Siswa</h3>
                </div>

                <div class="p-6 md:p-8">
           

                  <form method="POST" action="{{ route('profile.update.siswa') }}">

                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama Lengkap --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" 
                                    class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100"
                                    value="{{ old('nama', $siswa->nama) }}" disabled />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Kelas</label>
                                <input type="text" name="kelas" 
                                    class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100"
                                    value="{{ old('kelas', $siswa->kelas) }}" disabled />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Angkatan (Tahun)</label>
                                <input type="number" name="angkatan" 
                                    class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100"
                                    value="{{ old('angkatan', $siswa->angkatan) }}" disabled />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">No. Telepon Siswa</label>
                                <input type="text" name="telp" 
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                    value="{{ old('telp', $siswa->telp) }}" required />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">No. Telepon Orang Tua</label>
                                <input type="text" name="telp_orangtua" 
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                    value="{{ old('telp_orangtua', $siswa->telp_orangtua) }}" required />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" 
                                        class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100" 
                                        disabled>
                                    <option value="L" {{ $siswa->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $siswa->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" 
                                    class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100"
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" disabled />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Status Siswa</label>
                                <select name="status" 
                                        class="w-full rounded-xl border-gray-300 py-3 px-4 bg-gray-100"
                                        disabled>
                                    <option value="aktif" {{ $siswa->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak aktif" {{ $siswa->status === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" 
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition"
                                >{{ old('alamat', $siswa->alamat) }}</textarea>
                            </div>


                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-colors">
                                Kembali
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i data-feather="check-square" class="w-4 h-4"></i>
                                Simpan Biodata
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endhasrole

        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>