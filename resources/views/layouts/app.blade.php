<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Keuangan Sekolah - SMA Pasundan Cikalongkulon</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/logo.png">
    <link rel="apple-touch-icon" href="/assets/logo.png">
    <meta name="msapplication-TileImage" content="/assets/logo.png">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- TomSelect --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.default.min.css" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900" x-data="{ showSidebar: false }">

<div class="min-h-screen bg-gray-100">

    {{-- NAVBAR MOBILE --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm sticky top-0 z-50 md:hidden">
        <div class="px-4 h-16 flex items-center justify-between">

            {{-- Tombol Sidebar --}}
            <button @click="showSidebar = true"
                class="p-3 bg-white border rounded-xl  hover:bg-gray-100 transition">
                <i data-feather="menu" class="w-6 h-6 text-gray-700"></i>
            </button>

            {{-- Judul Navbar Mobile --}}
            <div class="text-center leading-tight">
                <h1 class="text-base font-bold text-gray-800">
                    Dashboard Siswa
                </h1>
            </div>

            {{-- Notification Component --}}
            <div x-data="notificationComponent()" class="relative">

                @if (Route::is('dashboard'))
                <button @click="toggleNotif()" class="p-2 rounded-full hover:bg-gray-100 relative">
                    <i data-feather="bell" class="w-6 h-6 text-gray-700"></i>
                    <template x-if="unreadCount > 0">
                        <span class="absolute top-0 right-0 h-4 w-4 rounded-full bg-red-500 text-white text-xs flex items-center justify-center">
                            <span x-text="unreadCount"></span>
                        </span>
                    </template>
                </button>
                @endif

                {{-- Dropdown Notifikasi --}}
                <div x-show="openNotif"
                    @click.outside="openNotif=false"
                    x-transition
                    class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border z-[9999]"
                    style="display:none;">
                    <div class="px-5 py-4 border-b bg-white flex justify-between items-center">
                        <span class="font-bold text-gray-800 text-sm">Notifikasi</span>
                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded">Terbaru</span>
                    </div>

                    <div class="max-h-72 overflow-y-auto">

                        <template x-if="notifications.length === 0">
                            <div class="px-6 py-10 text-center text-gray-400">
                                <i data-feather="bell-off" class="w-6 h-6 mx-auto mb-3"></i>
                                Tidak ada notifikasi
                            </div>
                        </template>

                        <template x-for="notif in notifications" :key="notif.id">
                            <div class="px-5 py-4 border-b hover:bg-gray-50 cursor-pointer">
                                <p class="text-sm font-semibold text-gray-700" x-text="notif.aktivitas"></p>
                                <p class="text-xs text-gray-400 flex items-center gap-1">
                                    <i data-feather="clock" class="w-3 h-3"></i>
                                    <span x-text="timeAgo(notif.waktu)"></span>
                                </p>
                            </div>
                        </template>

                    </div>
                </div>

            </div>

        </div>
    </nav>

    {{-- SIDEBAR --}}
    <div class="md:block" :class="showSidebar ? 'block' : 'hidden'">
        @include('layouts.navigation')
    </div>

    {{-- OVERLAY --}}
    <div x-show="showSidebar" @click="showSidebar=false"
        class="fixed inset-0 bg-black/40 md:hidden"></div>

    {{-- HEADER DESKTOP --}}
    @isset($header)
    <header class="bg-white shadow md:ml-64 hidden md:block">
        <div class="max-w-7xl mx-auto py-6 px-4">
            {{ $header }}
        </div>
    </header>
    @endisset

    {{-- MAIN CONTENT --}}
    <main>
        <div class="md:ml-64">
            {{ $slot }}
        </div>
    </main>
</div>

{{-- SCRIPTS --}}

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Select2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Feather Icons --}}
<script src="https://unpkg.com/feather-icons"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    feather.replace();
});
</script>

<script>
window.onload = () => {
    feather.replace();
    if (document.getElementById('preloader')) {
        document.getElementById('preloader').style.display = 'none';
    }
};
</script>

{{-- TomSelect --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

{{-- Alpine + Moment --}}
<script src="https://unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/locale/id.js"></script>

<script>
function notificationComponent() {
    moment.locale('id');
    return {
        openNotif: false,
        notifications: [],
        unreadCount: 0,

        async loadNotif() {
            const res = await fetch('{{ route("notifications.list") }}');
            const data = await res.json();
            this.notifications = data;
            this.unreadCount = data.filter(n => n.read_at === null).length;
        },

        async markAsRead() {
            await fetch('{{ route("notifications.readAll") }}', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Content-Type': 'application/json'}
            });
            this.unreadCount = 0;
        },

        async toggleNotif() {
            this.openNotif = !this.openNotif;
            if (this.openNotif) await this.markAsRead();
        },

        timeAgo(datetime) {
            return moment(datetime).fromNow();
        },

        init() { this.loadNotif(); }
    };
}
</script>

</body>
</html>
