
<nav class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-100 shadow-lg z-50 font-sans">
    <div class="h-full flex flex-col justify-between">

        {{-- BAGIAN ATAS --}}
        <div>
            {{-- Logo / Header --}}
            <div class="px-6 py-8 flex items-center gap-3">
                <div class="p-2 bg-blue-50 rounded-lg">
                    <x-application-logo class="h-8 w-8 text-blue-600" />
                </div>
                <div>
                  <span class="block text-lg font-bold text-gray-800 tracking-tight">E-Cek SPP</span>
                    @hasrole('admin')
                    <span class="block text-xs text-gray-400 font-medium uppercase tracking-wider">Admin Panel</span>
                    @endhasrole
                    @hasrole('siswa')
                    <span class="block text-xs text-gray-400 font-medium uppercase tracking-wider">Siswa Panel</span>
                    @endhasrole
                </div>
            </div>

            {{-- Menu Utama --}}
            <div class="px-4 mt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                        {{ request()->routeIs('dashboard') 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i data-feather="grid" 
                            class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    @hasrole('admin')
                    <li>
                        <a href="{{ route('siswa.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                            {{ request()->routeIs('siswa.*') 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i data-feather="users" 
                               class="w-5 h-5 {{ request()->routeIs('siswa.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                            <span>Data Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pembayaran.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                            {{ request()->routeIs('pembayaran.*') 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i data-feather="credit-card" 
                               class="w-5 h-5 {{ request()->routeIs('pembayaran.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                            <span>Pembayaran</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('spp.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                            {{ request()->routeIs('spp.*') 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i data-feather="book" 
                            class="w-5 h-5 {{ request()->routeIs('spp.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                            <span>SPP</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('keuangan.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                            {{ request()->routeIs('keuangan.*') 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i data-feather="trending-up" 
                               class="w-5 h-5 {{ request()->routeIs('keuangan.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                            <span>Keuangan</span>
                        </a>
                    </li>
                    @endhasrole
                    @hasrole('siswa')
   
                    <li>
                        <a href="{{ route('siswas.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                            {{ request()->routeIs('siswas.*') 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            
                            <i data-feather="file-text" class="w-5 h-5 {{ request()->routeIs('siswas.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                            <span>SPP</span>
                        </a>
                    </li>

                    @endhasrole



                </ul>
            </div>
        </div>
     <!-- BAGIAN BAWAH -->
        <div class="p-4 border-t border-gray-100 bg-gray-50 ">

            <div class="flex items-center gap-4 mb-4 px-2">
                <div class="h-12 w-12 rounded-full bg-white border border-blue-100 shadow flex items-center justify-center 
                            text-blue-600 font-bold text-lg uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>

                <div class="overflow-hidden leading-tight">
                    <div class="font-bold text-gray-800 truncate text-base">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200
                          rounded-lg hover:bg-gray-100 hover:text-blue-600 hover:border-gray-300 transition">
                    <i data-feather="user" class="w-4 h-4 mr-2"></i>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-semibold text-red-600 bg-white border border-red-200
                               rounded-lg hover:bg-red-50 hover:text-red-700 hover:border-red-300 transition">
                        <i data-feather="log-out" class="w-4 h-4 mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>

        </div>

    </div>
</nav>





