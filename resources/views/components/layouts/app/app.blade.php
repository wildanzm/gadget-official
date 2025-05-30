<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white">
    <header class="bg-[#EFF3FA] pt-6 pb-6 sm:pt-[30px] sm:pb-[30px]" x-data="{ mobileMenuOpen: false }">
        <nav
            class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-6 flex items-center justify-between bg-[#0D5CD7] p-4 sm:p-5 rounded-2xl sm:rounded-3xl">
            {{-- Logo --}}
            <div class="flex shrink-0">
                <a href="{{ url('/') }}">
                    <h2 class="font-bold text-white text-2xl sm:text-3xl">Gadget Official</h2>
                </a>
            </div>

            {{-- Tombol Menu Mobile --}}
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu"
                    class="text-white focus:outline-none p-2 rounded-md hover:bg-white/20 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                    </svg>
                </button>
            </div>

            {{-- Menu Desktop --}}
            <ul class="hidden md:flex items-center gap-5 lg:gap-[30px] text-sm lg:text-base">
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 font-bold text-[#FFC736]">
                    <a href="">Home</a> {{-- Ganti dengan nama route yang sesuai --}}
                </li>
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 text-white">
                    <a href="">Belanja</a> {{-- Ganti dengan nama route yang sesuai --}}
                </li>
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 text-white">
                    <a href="">Katalog</a> {{-- Ganti dengan nama route yang sesuai --}}
                </li>
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 text-white">
                    <a href="">Bonus</a> {{-- Ganti dengan nama route yang sesuai --}}
                </li>
            </ul>

            {{-- Tombol Aksi Desktop --}}
            <div class="hidden md:flex items-center gap-2 lg:gap-3">
                <a href="" class="p-2 text-white hover:text-[#FFC736] transition-colors">
                    <div class="w-10 h-10 sm:w-8 sm:h-8 flex shrink-0">
                        <img src="{{ asset('assets/images/icons/cart.svg') }}" alt="Shopping Cart">
                    </div>
                </a>

                {{-- Ganti bagian @auth di dalam "Tombol Aksi Desktop" Anda dengan ini --}}
                @auth
                    {{-- Wrapper untuk Dropdown Profil Pengguna --}}
                    <div class="relative ml-3" x-data="{ open: false }">
                        {{-- Tombol Pemicu Dropdown (Avatar dan Sapaan Nama) --}}
                        <div>
                            <button @click="open = !open" type="button"
                                class="flex items-center gap-2 rounded-full text-sm focus:outline-none focus:ring-offset-[#0D5CD7]"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Buka menu pengguna</span>
                                {{-- Avatar dengan Inisial Nama --}}
                                <div
                                    class="w-10 h-10 rounded-full bg-white text-[#0D5CD7] flex items-center justify-center text-lg font-semibold overflow-hidden">
                                    @php
                                        $name = auth()->user()->name;
                                        $words = explode(' ', $name);
                                        $initials = strtoupper(substr($words[0], 0, 1));
                                        if (count($words) > 1) {
                                            $initials .= strtoupper(substr(end($words), 0, 1));
                                        } elseif (strlen($words[0]) > 1 && count($words) == 1) {
                                            // Jika hanya satu kata dan lebih dari 1 huruf, ambil 2 huruf pertama
                                            $initials = strtoupper(substr($words[0], 0, 2));
                                        }
                                        // Jika satu kata dan hanya 1 huruf, $initials sudah benar
                                    @endphp
                                    {{ $initials }}
                                </div>
                                {{-- Sapaan Nama (Tampil di layar lg ke atas) --}}
                                <span class="text-white font-bold text-sm hidden lg:inline-block transition-colors">
                                    Halo, {{ Str::words(auth()->user()->name, 1, '') }}
                                </span>

                            </button>
                        </div>

                        {{-- Panel Dropdown --}}
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-md bg-white  py-1 shadow-lg focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                            x-cloak style="display: none;"> {{-- style="display: none;" untuk x-cloak --}}

                            {{-- Info Pengguna di Header Dropdown --}}
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-neutral-700">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#0D5CD7] text-white flex items-center justify-center text-lg font-semibold">
                                        {{ $initials }} {{-- Menggunakan variabel $initials yang sudah dihitung di atas --}}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 truncate"
                                            title="{{ auth()->user()->name }}">
                                            {{ auth()->user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-neutral-400 truncate"
                                            title="{{ auth()->user()->email }}">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Item Menu Dropdown --}}
                            <div class="py-1" role="none">
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50  hover:text-red-700 dark:hover:text-red-300"
                                        role="menuitem" tabindex="-1" id="user-menu-item-logout">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Jika Pengguna Belum Login (Guest) --}}
                    {{-- Kode tombol Masuk dan Daftar Akun Anda yang sudah ada --}}
                    <a href="{{ route('login') }}"
                        class="p-[8px_16px] lg:p-[12px_20px] bg-white text-black rounded-full font-semibold text-sm hover:bg-gray-100 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="p-[8px_16px] lg:p-[12px_20px] text-black bg-white rounded-full font-semibold text-sm hover:bg-gray-100 transition-colors">
                        Daftar Akun
                    </a>
                @endguest
            </div>
        </nav>

        {{-- Panel Menu Mobile --}}
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform -translate-x-full"
            class="fixed inset-y-0 left-0 w-3/4 max-w-xs bg-[#0D5CD7] shadow-xl z-50 p-6 md:hidden overflow-y-auto"
            x-cloak>

            <div class="flex justify-between items-center mb-6">
                <a href="{{ url('/') }}">
                    <h2 class="font-bold text-white text-2xl">Gadget Official</h2>
                </a>
                <button @click="mobileMenuOpen = false" aria-label="Close menu" class="text-white p-1">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @auth {{-- Jika Pengguna Sudah Login (Mobile) --}}
                <div class="mb-6 border-b border-white/20 pb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full bg-white text-[#0D5CD7] flex items-center justify-center text-xl font-semibold">
                            @php
                                $nameMobile = auth()->user()->name;
                                $wordsMobile = explode(' ', $nameMobile);
                                $initialsMobile = strtoupper(substr($wordsMobile[0], 0, 1));
                                if (count($wordsMobile) > 1) {
                                    $initialsMobile .= strtoupper(substr(end($wordsMobile), 0, 1));
                                }
                            @endphp
                            {{ $initialsMobile }}
                        </div>
                        <div>
                            <p class="font-semibold text-white text-base">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-300">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            @endauth

            <ul class="flex flex-col space-y-2 mb-6">
                <li><a href="{{ route('home') }}"
                        class="block py-2.5 px-3 rounded-md text-base font-medium text-white hover:bg-white/10 transition-colors">Beranda</a>
                </li>
                <li><a href=""
                        class="block py-2.5 px-3 rounded-md text-base font-medium text-white hover:bg-white/10 transition-colors">Belanja</a>
                </li>
                <li><a href=""
                        class="block py-2.5 px-3 rounded-md text-base font-medium text-white hover:bg-white/10 transition-colors">Katalog</a>
                </li>
                <li><a href=""
                        class="block py-2.5 px-3 rounded-md text-base font-medium text-white hover:bg-white/10 transition-colors">Bonus</a>
                </li>
            </ul>

            <div class="pt-4 border-t border-white/20 space-y-3">
                <a href=""
                    class="flex items-center py-2.5 px-3 rounded-md text-base font-medium text-white hover:bg-white/10 transition-colors">
                    <img src="{{ asset('assets/images/icons/cart.svg') }}" alt="Shopping Cart"
                        class="w-5 h-5 mr-2 filter invert brightness-0">
                    <span>Keranjang</span>
                </a>
                @auth {{-- Jika Pengguna Sudah Login (Mobile Logout) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full text-center py-2.5 px-3 bg-red-500 text-white rounded-full font-semibold text-base hover:bg-red-600 transition-colors">
                            Keluar
                        </a>
                    </form>
                @else
                    {{-- Jika Pengguna Belum Login (Mobile Login/Register) --}}
                    <a href="{{ route('login') }}"
                        class="block w-full text-center border-2 border-white py-2 px-3 bg-transparent text-white rounded-full font-semibold text-base hover:bg-white hover:text-[#0D5CD7] transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center py-2 px-3 bg-white text-[#0D5CD7] rounded-full font-semibold text-base hover:bg-gray-200 transition-colors">
                        Daftar
                    </a>
                @endguest
            </div>
        </div>
        {{-- Overlay untuk menutup menu mobile saat diklik di luar area menu --}}
        <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black/30 z-40 md:hidden" @click="mobileMenuOpen = false"
            x-cloak></div>
    </header>
    {{ $slot }}

    @fluxScripts
</body>

</html>
