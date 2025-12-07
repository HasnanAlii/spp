<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran SPP</title>

    <style>
        /* =============================
           1. PENGATURAN UMUM
        ============================== */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        /* =============================
           2. KOP SURAT RESMI
        ============================== */
        .header {
            margin-bottom: 15px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo {
            width: 80px;
            text-align: left;
            vertical-align: middle;
        }
        .header-text {
            text-align: center;
            padding-right: 80px; /* Agar teks benar-benar center */
            vertical-align: middle;
            font-family: 'Times New Roman', serif;
        }
        .header-text h1 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .header-text p {
            margin: 2px 0;
            font-style: italic;
            font-size: 10pt;
        }

        /* Garis Ganda */
        .header-line {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        /* =============================
           3. JUDUL LAPORAN
        ============================== */
        .report-title {
            text-align: center;
            font-family: 'Times New Roman', serif;
            margin-bottom: 20px;
        }
        .report-title h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
        }

        /* =============================
           4. TABEL DATA PEMBAYARAN
        ============================== */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-data th, .table-data td {
            border: 1px solid #000;
            padding: 6px 8px;
        }
        .table-data th {
            background: #f0f0f0;
            text-transform: uppercase;
            font-size: 10pt;
        }
        .table-data tr:nth-child(even) {
            background: #fafafa;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .font-mono { font-family: 'Courier New', monospace; }

        /* =============================
           5. RINGKASAN TOTAL
        ============================== */
        .table-summary {
            width: 40%;
            border-collapse: collapse;
            float: right;
            margin-bottom: 40px;
        }
        .table-summary td {
            border: 1px solid #000;
            padding: 5px 8px;
        }
        .bg-summary {
            background: #f0f0f0;
            font-weight: bold;
        }
        .text-green { color: #166534; }
        .text-red { color: #991b1b; }

        /* =============================
           6. TANDA TANGAN
        ============================== */
        .signature-section {
            clear: both;
            margin-top: 40px;
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
                <td class="header-logo">
                    <img src="{{ public_path('assets/logo.png') }}" width="80">
                </td>
                <td class="header-text">
                    <h1>SMA PASUNDAN CIKALONGKULON</h1>
                    <p>Jl. Aria Wiratanudatar, Cikalongkulon, Cianjur - Jawa Barat 43291</p>
                    <p>Email: smapasundancikalongkulon@gmail.com | Telp: (0263) 123456</p>
                </td>
            </tr>
        </table>

        <div class="header-line"></div>
    </div>

    {{-- JUDUL --}}
    <div class="report-title">
        <h3>LAPORAN PEMBAYARAN SPP</h3>
        <p>
            Periode:
            <strong>
                @switch($filter)
                    @case('harian') {{ now()->translatedFormat('d F Y') }} (Hari Ini) @break
                    @case('bulanan') {{ now()->translatedFormat('F Y') }} (Bulan Ini) @break
                    @case('tahunan') Tahun {{ now()->translatedFormat('Y') }} @break
                    @default Semua Data
                @endswitch
            </strong>
        </p>
    </div>

    {{-- TABEL PEMBAYARAN --}}
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">TANGGAL</th>
                <th width="25%">NAMA SISWA</th>
                <th width="10%">KELAS</th>
                <th width="30%">ITEM TAGIHAN</th>
                <th width="15%">JUMLAH (RP)</th>
            </tr>
        </thead>

        <tbody>
            @php $grandTotal = 0; @endphp

            @forelse($pembayarans as $i => $p)
                @php $grandTotal += $p->jumlah_bayar; @endphp

                <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td class="text-bold">
                        {{ $p->siswa->nama }}<br>
                        <span style="font-size: 10px">NIS: {{ $p->siswa->user->nis ?? '-' }}</span>
                    </td>
                    <td class="text-center">{{ $p->siswa->kelas }}</td>
                    <td>
                        {{ $p->sppSiswa->nama_spp }}<br>
                        <small>Tipe: {{ ucfirst($p->sppSiswa->tipe) }}</small>
                    </td>
                    <td class="text-right font-mono">
                        {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding:20px">
                        Tidak ada data pembayaran.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TOTAL --}}
    <table class="table-summary">
        <tr>
            <td class="bg-summary">Total Pembayaran Masuk</td>
            <td class="text-right text-green">
                Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td width="60%"></td>
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
