<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6 flex justify-between items-center">
                        <a href="{{ route('siswa.index') }}" class="text-blue-500 hover:text-blue-700">
                            ← Kembali ke Daftar Siswa
                        </a>
                        
                        @if(Auth::user()->role != 'siswa')
                        <div class="flex space-x-2">
                            <a href="{{ route('siswa.edit', $siswa) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit Data
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">NISN</label>
                                <p class="mt-1 text-lg">{{ $siswa->nisn }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-lg">{{ $siswa->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Kelas</label>
                                <p class="mt-1 text-lg">{{ $siswa->kelas }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nomor Telepon</label>
                                <p class="mt-1 text-lg">{{ $siswa->telp }}</p>
                            </div>
                        </div>
                    </div>

                    @if(isset($siswa->pembayarans) && $siswa->pembayarans->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Riwayat Pembayaran</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">No</th>
                                        <th class="py-2 px-4 border-b">Jenis</th>
                                        <th class="py-2 px-4 border-b">Periode/Bulan</th>
                                        <th class="py-2 px-4 border-b">Jumlah</th>
                                        <th class="py-2 px-4 border-b">Tanggal Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa->pembayarans as $key => $pembayaran)
                                    <tr>
                                        <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                        <td class="py-2 px-4 border-b">
                                            @if($pembayaran->bulanan)
                                                Bulanan
                                            @elseif($pembayaran->tahunan)
                                                Tahunan
                                            @else
                                                Lainnya
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            @if($pembayaran->bulanan)
                                                {{ $pembayaran->bulanan->nama_bulan }}
                                            @elseif($pembayaran->tahunan)
                                                {{ $pembayaran->tahunan->tahun_ajaran }}
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b">{{ $pembayaran->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        Belum ada riwayat pembayaran
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>