<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistem Cek SPP - SMA Pasundan Cikalongkulon</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/logo.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/logo.png">
        <link rel="apple-touch-icon" href="/assets/logo.png">
        <meta name="msapplication-TileImage" content="/assets/logo.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.default.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="font-sans antialiased" x-data="{ showSidebar: false }">

    <div class="min-h-screen bg-gray-100">

        <!-- TOMBOL TAMPIL SIDEBAR (Mobile Only) -->
        <button 
            @click="showSidebar = !showSidebar"
            class="md:hidden p-3 m-3 bg-white border rounded-xl shadow flex items-center gap-2"
        >
            <i data-feather="menu" class="w-5 h-5"></i>
            <span class="text-sm font-semibold">Menu</span>
        </button>

        <!-- SIDEBAR -->
        <div 
            class="md:block"
            :class="showSidebar ? 'block' : 'hidden'"
        >
            @include('layouts.navigation')
        </div>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow md:ml-64">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            <div class="md:ml-64">
                {{ $slot }}
            </div>
        </main>

        <!-- Overlay ketika sidebar muncul di mobile -->
        <div 
            x-show="showSidebar"
            @click="showSidebar = false"
            class="fixed inset-0 bg-black/40 md:hidden"
        ></div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>


        <script>
        window.onload = () => {
            feather.replace();
            document.getElementById('preloader').style.display = 'none';
        };
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", () => feather.replace());
        </script>

        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

</body>
</html>

