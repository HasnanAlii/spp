<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        /* 1. PENGATURAN UMUM */
        body {
            font-family: 'Arial', sans-serif; /* Font isi laporan */
            font-size: 11pt;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        /* 2. KOP SURAT (HEADER) */
        .header {
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .header-logo {
            width: 80px;
            vertical-align: middle;
            text-align: left;
        }
        .header-text {
            vertical-align: middle;
            text-align: center;
            /* Padding kanan dibuat sama dengan lebar logo agar teks benar-benar di tengah kertas */
            padding-right: 80px; 
            font-family: 'Times New Roman', serif; /* Font resmi kop surat */
        }
        .header-text h1 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .header-text h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 3px 0;
        }
        .header-text p {
            font-size: 10pt;
            font-style: italic;
            margin: 2px 0;
        }
        
        /* Garis Ganda Kop Surat */
        .header-line {
            border-top: 3px solid #000;    /* Garis tebal atas */
            border-bottom: 1px solid #000; /* Garis tipis bawah */
            height: 2px;                   /* Jarak antar garis */
            margin-bottom: 25px;
        }

        /* 3. JUDUL LAPORAN */
        .report-title {
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Times New Roman', serif;
        }
        .report-title h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0 0 5px 0;
        }
        .report-info {
            font-size: 11pt;
        }

        /* 4. TABEL DATA */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-data th, .table-data td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }
        .table-data th {
            background-color: #f0f0f0; /* Abu-abu muda */
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 10pt;
        }
        .table-data tr:nth-child(even) {
            background-color: #fafafa; /* Zebra striping tipis */
        }

        /* 5. TABEL REKAPITULASI (RINGKASAN) */
        .table-summary {
            width: 40%; /* Lebar tabel ringkasan */
            float: right; /* Posisi di kanan */
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .table-summary td {
            padding: 5px 10px;
            border: 1px solid #000;
        }
        .bg-summary {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* 6. UTILITY CLASSES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-green { color: #166534; } /* Hijau tua */
        .text-red { color: #991b1b; }   /* Merah tua */
        
        /* 7. TANDA TANGAN */
        .signature-section {
            width: 100%;
            margin-top: 30px;
            clear: both; /* Membersihkan float dari tabel summary */
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="header">
        <table class="header-table">
            <tr>
                {{-- LOGO (KIRI) --}}
                <td class="header-logo">
                    {{-- Gunakan public_path agar gambar terbaca oleh DomPDF --}}
                    <img src="{{ public_path('assets/logo.png') }}" width="80" alt="Logo">
                </td>
                
                {{-- TEKS (TENGAH) --}}
                <td class="header-text">
                    <h1>SMA PASUNDAN CIKALONGKULON</h1>
                    <p>Jl. Aria Wiratanudatar, Cikalongkulon, Cianjur - Jawa Barat 43291</p>
                    <p>Email: smapasundancikalongkulon@gmail.com | Telp: (0263) 123456</p>
                </td>
            </tr>
        </table>
        {{-- Garis Ganda --}}
        <div class="header-line"></div>
    </div>

    {{-- JUDUL LAPORAN --}}
    <div class="report-title">
        <h3>LAPORAN KEUANGAN</h3>
        <div class="report-info">
            Periode: 
            <strong>
                @if(request('filter') == 'harian')
                    {{ \Carbon\Carbon::parse(request('date'))->translatedFormat('d F Y') }}
                @elseif(request('filter') == 'bulanan')
                    {{ \Carbon\Carbon::parse(request('date'))->translatedFormat('F Y') }}
                @else
                    Semua Periode
                @endif
            </strong>
        </div>
    </div>

    {{-- TABEL DATA TRANSAKSI --}}
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">TANGGAL</th>
                <th>KETERANGAN / URAIAN</th>
                <th width="15%">PEMASUKAN</th>
                <th width="15%">PENGELUARAN</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotalMasuk = 0;
                $grandTotalKeluar = 0;
            @endphp

            @forelse($keuangans as $index => $item)
                @php
                    if($item->arus_dana == 'masuk') {
                        $grandTotalMasuk += $item->jumlah;
                    } else {
                        $grandTotalKeluar += $item->jumlah;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    
                    {{-- Kolom Pemasukan --}}
                    <td class="text-right">
                        @if($item->arus_dana == 'masuk')
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    {{-- Kolom Pengeluaran --}}
                    <td class="text-right">
                        @if($item->arus_dana == 'keluar')
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">
                        <i>Tidak ada data transaksi pada periode ini.</i>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TABEL REKAPITULASI (RINGKASAN) --}}
    {{-- Menggunakan float:right agar posisinya di kanan bawah tabel --}}
    <table class="table-summary">
        <tr>
            <td class="bg-summary">Total Pemasukan</td>
            <td class="text-right text-green">+ Rp {{ number_format($grandTotalMasuk, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="bg-summary">Total Pengeluaran</td>
            <td class="text-right text-red">- Rp {{ number_format($grandTotalKeluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="bg-summary">Saldo Akhir</td>
            <td class="text-right text-bold">
                Rp {{ number_format($grandTotalMasuk - $grandTotalKeluar, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td width="60%">
                    {{-- Kolom Kiri Kosong (atau untuk mengetahui pihak lain) --}}
                </td>
                <td width="40%">
                    Cianjur, {{ now()->translatedFormat('d F Y') }}<br>
                    Bendahara Sekolah,
                    <br><br><br><br><br>
                    <u class="text-bold">{{ Auth::user()->name ?? 'Nama Bendahara' }}</u><br>
                    NIP. ...........................
                </td>
            </tr>
        </table>
    </div>

</body>
</html>