<x-app-layout>
    {{-- SCRIPT DEPENDENCY (MOMENT.JS untuk waktu notifikasi) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4" x-data="notificationComponent()">
            
            {{-- TITLE & BREADCRUMB --}}
            <div class="flex flex-col">
                <h2 class="font-extrabold text-2xl text-gray-800 leading-tight tracking-tight">
                    {{ __('Dashboard Siswa') }}
                </h2>
                <nav class="flex text-sm font-medium text-gray-500 mt-1">
                    <span class="text-blue-600 cursor-default">Panel Siswa</span>
                </nav>
            </div>

            {{-- NOTIFIKASI --}}
            <div class="relative">
                <button 
                    @click="toggleNotif()" 
                    class="relative p-2.5 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-100 shadow-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <template x-if="unreadCount > 0">
                        <span class="absolute top-2 right-2 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                        </span>
                    </template>
                </button>

                {{-- DROPDOWN NOTIFIKASI --}}
                <div x-show="openNotif"
                     @click.outside="openNotif = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     style="display: none;"
                     class="absolute right-0 mt-4 w-80 md:w-96 bg-white shadow-2xl shadow-slate-200/50 rounded-2xl border border-slate-100 z-50 overflow-hidden ring-1 ring-black/5 origin-top-right"
                >
                    <div class="px-5 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                        <span class="font-bold text-slate-800 text-sm">Notifikasi</span>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">
                           Terbaru
                        </span>
                    </div>

                    <div class="max-h-[350px] overflow-y-auto custom-scrollbar">
                        <template x-if="notifications.length === 0">
                            <div class="px-6 py-12 text-center flex flex-col items-center justify-center text-slate-400">
                                <div class="bg-slate-50 p-3 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Belum ada notifikasi baru</span>
                            </div>
                        </template>

                        <template x-for="notif in notifications" :key="notif.id">
                            <div class="group px-5 py-4 hover:bg-slate-50 transition-colors duration-200 border-b border-slate-50 last:border-0 cursor-pointer relative">
                                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                
                                <div class="flex justify-between items-start gap-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-700 group-hover:text-blue-700 transition-colors leading-relaxed" x-text="notif.aktivitas"></p>
                                        <div class="flex items-center gap-1.5 mt-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-xs text-slate-500 font-medium" x-text="timeAgo(notif.waktu)"></p>
                                        </div>
                                    </div>
                                    <div class="mt-1.5 h-2 w-2 rounded-full bg-blue-500 shadow-sm" x-show="!notif.read_at"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen px-3">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. GREETING CARD --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800">
                            Halo, <span class="text-emerald-600">{{ Auth::user()->name }}</span>! 
                            <span class="inline-block animate-bounce">👋</span>
                        </h3>
                        <p class="text-slate-500 mt-2 text-lg">
                            Berikut informasi status pembayaran dan tagihan SPP kamu.
                        </p>
                    </div>
                </div>
                {{-- Decoration --}}
                <div class="hidden md:block absolute top-0 right-0 w-64 h-64 -mr-10 -mt-10 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-full opacity-50 blur-3xl pointer-events-none"></div>
            </div>

            {{-- 2. STATISTIK GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- CARD: Sisa Tagihan (Rose/Red) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-rose-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-rose-100 text-rose-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa Tagihan</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight">
                            Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- CARD: Status Bulan Ini (Blue) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">SPP Bulan Ini</p>
                        </div>
                        <div class="flex items-center">
                            @if($pembayaranBulanIni)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">Lunas</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">Belum Bayar</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD: Total Dibayar (Emerald/Green) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-16 w-16 bg-emerald-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dibayar</p>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 font-mono tracking-tight">
                            Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- 3. RIWAYAT TABLE --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-3xl overflow-hidden border border-slate-100">
                
                {{-- Header Tabel --}}
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="font-bold text-xl text-slate-800">Riwayat Pembayaran Kamu</h3>
                        <p class="text-sm text-slate-500 mt-1">Daftar transaksi terakhir yang berhasil diverifikasi.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">

                            @forelse($riwayat as $bayar)
                                <tr class="hover:bg-blue-50/40 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                        {{ $bayar->tanggal_bayar->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $bayar->keterangan ?? 'Pembayaran SPP' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-bold text-emerald-600 font-mono tracking-tight bg-emerald-50 px-2 py-1 rounded-md">
                                            Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-500">
                                            <div class="bg-slate-50 p-3 rounded-full mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium">Belum ada riwayat pembayaran.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

<script>
function notificationComponent() {
    moment.locale('id'); 

    return {
        openNotif: false,
        notifications: [],
        unreadCount: 0,

        async loadNotif() {
            try {
                const res = await fetch('/notifications');
                if (!res.ok) throw new Error('Network response was not ok');
                const data = await res.json();
                this.notifications = data;
                this.unreadCount = data.filter(n => n.read_at === null).length;
            } catch (error) {
                console.error('Gagal memuat notifikasi:', error);
            }
        },

        async markAsRead() {
            try {
                await fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    }
                });
                this.unreadCount = 0;
            } catch (error) {
                console.error('Gagal menandai baca:', error);
            }
        },

        async toggleNotif() {
            this.openNotif = !this.openNotif;
            if (this.openNotif && this.unreadCount > 0) {
                await this.markAsRead();
            }
        },

        timeAgo(datetime) {
            return moment(datetime).fromNow();
        },

        init() {
            this.loadNotif();
            // Polling setiap 60 detik (Opsional)
            // setInterval(() => this.loadNotif(), 60000);
        }
    }
}
</script>