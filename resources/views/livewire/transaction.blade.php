<div>
    <div class="container max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Judul Halaman --}}
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Daftar Transaksi</h1>
        </div>

        @if (session()->has('info'))
            <div class="mb-6 p-4 text-sm text-blue-700 bg-blue-100 rounded-lg" role="alert">
                {{ session('info') }}
            </div>
        @endif

        {{-- Daftar Kartu Transaksi --}}
        <div class="space-y-6">
            @forelse ($orders as $order)
                <div wire:key="order-{{ $order->id }}"
                    class="bg-white shadow-md rounded-xl border border-gray-200 overflow-hidden">
                    {{-- Header Kartu: Kode Transaksi, Tanggal, Status --}}
                    <div
                        class="bg-gray-50 p-4 sm:p-5 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <div>
                            <p class="text-sm text-gray-600">Kode Transaksi:</p>
                            <p class="font-semibold text-gray-800 text-base sm:text-lg">{{ $order->order_code }}</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-sm text-gray-600 text-center">Tanggal Pembelian:</p>
                            <p class="font-medium text-gray-700 text-center text-sm">{{ $order->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div class="w-full sm:w-auto mt-2 sm:mt-0 text-left sm:text-right">
                            <p class="text-sm text-gray-600">Status Pembayaran:</p>
                            @if (strtolower($order->status) == 'pending')
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Belum
                                    Dibayar</span>
                            @elseif(strtolower($order->status) == 'paid' ||
                                    strtolower($order->status) == 'completed' ||
                                    strtolower($order->status) == 'delivered')
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Sudah
                                    Dibayar</span>
                            @elseif(strtolower($order->status) == 'cancelled' || strtolower($order->status) == 'failed')
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">{{ Str::ucfirst($order->status) }}</span>
                            @else
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">{{ Str::ucfirst($order->status) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Detail Item Produk dalam Transaksi --}}
                    <div class="p-4 sm:p-5 space-y-4">
                        @foreach ($order->items as $item)
                            <div wire:key="order-{{ $order->id }}-item-{{ $item->id }}"
                                class="flex flex-col sm:flex-row gap-4 items-start">
                                <div
                                    class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden shrink-0">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                    @else
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-gray-800 text-base leading-tight">
                                        {{ optional($item->product)->name ?? 'Produk Tidak Tersedia' }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $item->quantity }} barang x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-left sm:text-right shrink-0 mt-2 sm:mt-0">
                                    <p class="text-xs text-gray-500">Total Harga Item</p>
                                    <p class="font-semibold text-gray-800 text-base">Rp
                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="border-gray-200">
                            @endif
                        @endforeach
                    </div>

                    {{-- Footer Kartu: Metode Pembayaran, Grand Total, Aksi --}}
                    <div
                        class="bg-gray-50 p-4 sm:p-5 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div>
                            <p class="text-sm text-gray-600">Metode Pembayaran:</p>
                            <p class="font-semibold text-gray-800">
                                @if (strtolower($order->payment_method) == 'cash')
                                    Tunai / Transfer
                                @elseif (strtolower($order->payment_method) == 'installment')
                                    Cicilan @if ($order->installment_plan)
                                        ({{ $order->installment_plan }})
                                    @endif
                                @else
                                    {{ Str::ucfirst($order->payment_method) }}
                                @endif
                            </p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-sm text-gray-600">Total Keseluruhan:</p>
                            <p class="font-bold text-lg sm:text-xl text-blue-600">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <button wire:click="printInvoice({{ $order->id }})" type="button"
                            class="w-full sm:w-auto mt-3 sm:mt-0 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm7-8a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Cetak Invoice
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-xl shadow border border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Belum Ada Transaksi</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum melakukan transaksi apapun.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" {{-- Ganti 'home' dengan route halaman belanja utama Anda --}}
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginasi --}}
        @if ($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
