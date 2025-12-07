<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Keuangan Sekolah - SMA Pasundan Cikalongkulon</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/logo.png">
    <link rel="apple-touch-icon" href="/assets/logo.png">
    <meta name="msapplication-TileImage" content="/assets/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-100 blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[30%] h-[30%] rounded-full bg-indigo-100 blur-3xl opacity-50"></div>
    </div>

    {{-- NAVBAR --}}
    <header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            
            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-600 rounded-xl blur opacity-20 group-hover:opacity-40 transition"></div>
                    <img src="/assets/logo.png" class="relative w-10 h-10 md:w-12 md:h-12 rounded-xl object-contain bg-white shadow-sm" alt="Logo">
                </div>
                <div>
                    <h1 class="text-lg md:text-xl font-bold tracking-tight text-slate-900 group-hover:text-blue-700 transition">
                        SMA Pasundan
                    </h1>
                    <p class="text-[10px] md:text-xs font-semibold text-blue-600 uppercase tracking-wider">Cikalongkulon</p>
                </div>
            </a>

            {{-- TOMBOL AUTH --}}
            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="hidden md:inline-flex items-center justify-center px-5 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 border border-transparent rounded-full shadow-sm hover:bg-blue-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-blue-600 rounded-full shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-0.5">
                            Masuk
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    {{-- HERO SECTION --}}
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold mb-6 animate-fade-in-up">
                Sistem Informasi Keuangan Sekolah
            </div>

            <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 text-slate-900 tracking-tight">
                Kelola Keuangan Sekolah <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                    Lebih Mudah, Modern & Transparan
                </span>
            </h2>

            <p class="text-lg md:text-xl text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform resmi SMA Pasundan Cikalongkulon untuk mengelola transaksi, pembayaran siswa, laporan keuangan,
                dan administrasi sekolah secara digital dan real-time.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-slate-900 rounded-xl hover:bg-slate-800 hover:shadow-xl hover:-translate-y-1">
                    Akses Sistem
                </a>
                <a href="#fitur"
                   class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-slate-700 transition-all duration-200 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600">
                    Pelajari Fitur
                </a>
            </div>

        </div>
    </section>

    {{-- FITUR SECTION --}}
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-slate-900 mb-4">Fitur Utama</h3>
                <p class="text-slate-500 max-w-xl mx-auto">
                    Kelola seluruh data keuangan sekolah dalam satu platform terpadu.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">

                {{-- Feature 1 --}}
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-blue-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 text-blue-600 group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600">Manajemen Tagihan Siswa</h4>
                    <p class="text-slate-500">Atur biaya SPP, daftar ulang, ujian, dan pembayaran lain dengan lebih terstruktur.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-emerald-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 text-emerald-600 group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-emerald-600">Riwayat Transaksi</h4>
                    <p class="text-slate-500">Lihat semua transaksi masuk & keluar dengan detail yang lengkap dan akurat.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-indigo-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 text-indigo-600 group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-600">Laporan Keuangan</h4>
                    <p class="text-slate-500">Generate laporan bulanan & tahunan secara otomatis, rapi, dan siap cetak.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-200 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                
                <div class="flex items-center gap-3">
                    <img src="/assets/logo.png" class="w-8 h-8 grayscale opacity-50" alt="Logo">
                    <span class="text-sm font-semibold text-slate-400">SMA Pasundan Cikalongkulon</span>
                </div>

                <div class="text-sm text-slate-400">
                    &copy; {{ date('Y') }} Sistem Keuangan Sekolah. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
