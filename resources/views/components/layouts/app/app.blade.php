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
                <a href="{{ url('/') }}"> {{-- Ganti dengan route ke halaman utama jika ada --}}
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
                    {{-- Ganti dengan nama route yang sesuai, contoh: route('shop.index') --}}
                    <a href="">Home</a>
                </li>
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 text-white">
                    <a href="">Belanja</a>
                </li>
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 text-white">
                    <a href="">Katalog</a>
                </li>
                <li class="hover:font-bold hover:text-[#FFC736] transition-all duration-300 text-white">
                    <a href="">Bonus</a>
                </li>
            </ul>

            {{-- Tombol Aksi Desktop --}}
            <div class="hidden md:flex items-center gap-2 lg:gap-3">
                <a href="" class="p-2 text-white hover:text-[#FFC736] transition-colors">
                    <div class="w-7 h-7 sm:w-12 sm:h-12 flex shrink-0"> {{-- Ukuran ikon cart disesuaikan --}}
                        <img src="{{ asset('assets/images/icons/cart.svg') }}" alt="Shopping Cart">
                    </div>
                </a>
                <a href="{{ route('login') }}"
                    class="p-[8px_16px] lg:p-[12px_20px] bg-white text-black rounded-full font-semibold text-sm hover:bg-gray-100 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="p-[8px_16px] lg:p-[12px_20px] text-black bg-white rounded-full font-semibold text-sm hover:bg-gray-100 transition-colors">
                    Daftar Akun
                </a>
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
            class="fixed inset-y-0 left-0 w-3/4 max-w-xs bg-[#0D5CD7] shadow-xl z-50 p-6 md:hidden" x-cloak>

            <div class="flex justify-between items-center mb-6">
                <a href="{{ url('/') }}">
                    <h2 class="font-bold text-white text-2xl sm:text-3xl">Gadget Official</h2>
                </a>
                <button @click="mobileMenuOpen = false" aria-label="Close menu" class="text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <ul class="flex flex-col space-y-3 mb-6">
                <li>
                    <a href="" class="block py-2 px-3 rounded-md text-base font-medium text-white">Beranda</a>
                </li>
                <li>
                    <a href="" class="block py-2 px-3 rounded-md text-base font-medium text-white">Belanja</a>
                </li>
                <li>
                    <a href=""
                        class="block py-2 px-3 rounded-md text-base font-medium text-white">Katalog</a>
                </li>
                <li>
                    <a href="" class="block py-2 px-3 rounded-md text-base font-medium text-white">Bonus</a>
                </li>
            </ul>

            <div class="pt-4 border-t border-gray-200 space-y-3">
                <a href="" class="flex items-center py-2 px-3 rounded-md text-base font-medium text-white">
                    <img src="{{ asset('assets/images/icons/cart.svg') }}" alt="Shopping Cart"
                        class="w-5 h-5 mr-2 filter">
                    <span>Keranjang</span>
                </a>
                <a href="{{ route('login') }}"
                    class="block w-full text-center border-2 border-white py-2 px-3 bg-[#0D5CD7] text-white rounded-full font-semibold text-base hover:bg-blue-700 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="block w-full text-center py-2 px-3 bg-white text-black rounded-full font-semibold text-base hover:bg-gray-300 transition-colors">
                    Daftar
                </a>
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
