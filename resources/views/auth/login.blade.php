<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-200">

        <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">
            Login Sistem Cek SPP
        </h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- NIS --}}
            <div class="mb-4">
                <x-input-label for="nis" :value="'NIS Siswa'" class="font-semibold text-gray-700" />
                
                <x-text-input 
                    id="nis"
                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    type="text"
                    name="nis"
                    placeholder="Masukkan NIS Anda"
                    :value="old('nis')"
                    required 
                    autofocus 
                    autocomplete="username" 
                />

                <x-input-error :messages="$errors->get('nis')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <x-input-label for="password" :value="'Password'" class="font-semibold text-gray-700" />

                <x-text-input 
                    id="password"
                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    required
                    autocomplete="current-password"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

 

            {{-- Tombol --}}
            <div class="mt-6">
                <x-primary-button class="w-full flex justify-center py-3 text-lg bg-blue-600 hover:bg-blue-700">
                    Masuk
                </x-primary-button>
            </div>

        </form>
    </div>

</x-guest-layout>
