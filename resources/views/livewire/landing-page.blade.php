<div>
    <div class="bg-[#EFF3FA] pt-[5px] pb-12 md:pb-[50px]">
        <div
            class="container max-w-[1130px] mx-auto px-4 sm:px-6 flex flex-col lg:flex-row items-center lg:justify-between gap-8 lg:gap-12 mt-10 md:mt-[50px]">

            {{-- Kolom Teks (Kiri di Desktop, Atas di Mobile) --}}
            <div
                class="flex flex-col gap-6 md:gap-[30px] text-center lg:text-left w-full lg:w-1/2 xl:w-2/5 order-2 lg:order-1">
                <div class="flex justify-center lg:justify-start">
                    <div class="flex items-center gap-[10px] p-[8px_16px] rounded-full bg-white w-fit shadow-md">
                        <div class="w-[22px] h-[22px] flex shrink-0">
                            <img src="{{ asset('assets/images/icons/crown.svg') }}" alt="Ikon Mahkota">
                        </div>
                        <p class="font-semibold text-black text-sm">Produk Ke-100 Terpopuler di Gadget Official!</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 md:gap-[14px]">
                    <h1
                        class="font-bold text-black text-4xl sm:text-5xl lg:text-[55px] leading-tight sm:leading-tight lg:leading-[55px]">
                        Temukan Gadget Impianmu Disini!
                    </h1>
                    <p
                        class="text-base sm:text-lg leading-relaxed sm:leading-[34px] text-[#6A7789] max-w-lg mx-auto lg:mx-0">
                        Nikmati fitur super canggih dengan integrasi AI dari Gadget Official, lebih kaya dari platform
                        lain untuk semua perangkat Anda.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4">
                    <a href="#" {{-- Ganti dengan route('cart.add', ['product_id' => ID_PRODUK]) --}}
                        class="w-full sm:w-auto p-4 sm:p-[18px_24px] rounded-full font-semibold bg-[#0D5CD7] text-white text-center text-sm sm:text-base hover:bg-blue-700 transition-colors">
                        Belanja
                    </a>
                    <a href="#" {{-- Ganti dengan route('product.details', ['product_slug' => SLUG_PRODUK]) --}}
                        class="w-full sm:w-auto p-4 sm:p-[18px_24px] text-black rounded-full font-semibold bg-white text-center text-sm sm:text-base shadow-md hover:bg-gray-50 transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            {{-- Kolom Gambar (Kanan di Desktop, Bawah di Mobile) --}}
            <div
                class="w-full max-w-lg mx-auto lg:w-1/2 xl:w-3/5 lg:max-w-none lg:mx-0 h-auto lg:h-[450px] {{-- Tinggi untuk desktop dinaikkan dari 400px ke 450px --}}
            flex items-center justify-center shrink-0 relative mt-8 lg:mt-0 order-1 lg:order-2">
                <img src="{{ asset('assets/images/thumbnails/iphone15pro-digitalmat-gallery-3-202309-Photoroom 1.png') }}"
                    class="max-h-[300px] sm:max-h-[360px] lg:max-h-[450px] object-contain" {{-- Nilai max-h dinaikkan --}}
                    alt="iPhone 15 Pro Terbaru di Gadget Official">

                {{-- Badge Bonus --}}
                <div
                    class="absolute 
                bottom-2 left-2 xs:bottom-4 xs:left-4 
                sm:top-[60%] sm:bottom-auto sm:left-4 md:left-6
                bg-white p-2.5 px-3 sm:p-[14px_16px] rounded-2xl sm:rounded-3xl 
                flex items-center gap-2 sm:gap-[10px] shadow-lg transition-all hover:scale-105">
                    <div
                        class="w-8 h-8 sm:w-12 sm:h-12 flex shrink-0 rounded-full items-center justify-center bg-[#FFC736] overflow-hidden">
                        <img src="{{ asset('assets/images/icons/code-circle.svg') }}" class="w-4 h-4 sm:w-6 sm:h-6"
                            alt="Ikon Kode Bonus">
                    </div>
                    <p class="font-semibold text-black text-xs sm:text-sm leading-tight">Bonus Eksklusif</p>
                </div>

                {{-- Badge Garansi --}}
                <div
                    class="absolute 
                top-2 right-2 xs:top-4 xs:right-4 
                sm:top-[30%] sm:bottom-auto sm:right-4 md:right-6
                bg-white p-2.5 px-3 sm:p-[14px_16px] rounded-2xl sm:rounded-3xl 
                flex flex-col items-center text-center gap-1 sm:gap-[10px] shadow-lg transition-all hover:scale-105">
                    <div
                        class="w-8 h-8 sm:w-12 sm:h-12 flex shrink-0 rounded-full items-center justify-center bg-[#FFC736] overflow-hidden">
                        <img src="{{ asset('assets/images/icons/star-outline.svg') }}" class="w-4 h-4 sm:w-6 sm:h-6"
                            alt="Ikon Garansi Bintang">
                    </div>
                    <p class="font-semibold text-black text-xs sm:text-sm leading-tight">Garansi Resmi</p>
                </div>
            </div>
        </div>
    </div>
    <section id="content" class="container max-w-[1130px] mx-auto flex flex-col gap-[50px] pt-[50px] pb-[100px]">
        <div id="new-release" class="flex flex-col gap-[30px]">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-black text-2xl leading-[34px]">Produk Terbaru</h2>
                <a href="catalog.html" class="p-[12px_24px] border border-[#E5E5E5] rounded-full font-semibold">Selengkapnya</a>
            </div>
            <div class="grid grid-cols-5 gap-[30px]">
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/color_back_green__buxxfjccqjzm_large_2x-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">iMac Green Energy</p>
                                <p class="text-sm text-[#616369]">Desktops</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 24.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/iphone15pro-digitalmat-gallery-3-202309-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">Smartwei Pro 18</p>
                                <p class="text-sm text-[#616369]">Phones</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 11.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/banners/mba13-m2-digitalmat-gallery-1-202402-Photoroom 2.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">MacBook Pro X</p>
                                <p class="text-sm text-[#616369]">Laptops</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 24.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/airpods-max-select-skyblue-202011-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">Tuli Nyaman</p>
                                <p class="text-sm text-[#616369]">Headsets</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 3.500.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/imac24-digitalmat-gallery-1-202310-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">Warna iMac Jadi</p>
                                <p class="text-sm text-[#616369]">Desktops</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 89.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/imac24-digitalmat-gallery-1-202310-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">Warna iMac Jadi</p>
                                <p class="text-sm text-[#616369]">Desktops</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 89.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/airpods-max-select-skyblue-202011-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">Tuli Nyaman</p>
                                <p class="text-sm text-[#616369]">Headsets</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 3.500.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/color_back_green__buxxfjccqjzm_large_2x-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">iMac Green Energy</p>
                                <p class="text-sm text-[#616369]">Desktops</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 24.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/thumbnails/iphone15pro-digitalmat-gallery-3-202309-Photoroom 1.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">Smartwei Pro 18</p>
                                <p class="text-sm text-[#616369]">Phones</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 11.000.000</p>
                        </div>
                    </div>
                </a>
                <a href="details.html" class="product-card">
                    <div
                        class="bg-white flex flex-col gap-[24px] p-5 rounded-[20px] ring-1 ring-[#E5E5E5] hover:ring-2 hover:ring-[#FFC736] transition-all duration-300 w-full">
                        <div class="w-full h-[90px] flex shrink-0 items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/images/banners/mba13-m2-digitalmat-gallery-1-202402-Photoroom 2.png') }}"
                                class="w-full h-full object-contain" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-black leading-[22px]">MacBook Pro X</p>
                                <p class="text-sm text-[#616369]">Laptops</p>
                            </div>
                            <p class="font-semibold text-[#0D5CD7] leading-[22px]">Rp 24.000.000</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
