<div>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        {{-- Judul Halaman --}}
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Data Pesanan</h1>
            {{-- Tambahkan tombol lain di sini jika perlu, misal filter global --}}
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300"
                role="alert">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300"
                role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Input Pencarian --}}
        <div class="mb-4">
            <label for="order_search" class="sr-only">Cari Pesanan</label>
            <input wire:model.live.debounce.300ms="search" type="search" id="order_search"
                class="block w-full sm:w-1/2 md:w-1/3 p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Cari kode, nama pembeli, atau produk...">
            {{-- Ikon search bisa ditambahkan di sini jika diinginkan, mirip contoh Laporan Penjualan --}}
        </div>


        {{-- Kontainer Tabel --}}
        <div
            class="relative overflow-x-auto hide-scrollbar shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 sm:px-6 w-10">No.</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 whitespace-nowrap">Kode Transaksi</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 whitespace-nowrap">Nama Pembeli</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 whitespace-nowrap">Nama Produk</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 text-center">Jumlah</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 text-right whitespace-nowrap">Harga Satuan</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 text-right whitespace-nowrap">Total Harga Item</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 text-center whitespace-nowrap">Status Bayar</th>
                        <th scope="col" class="px-4 py-3 sm:px-6">Alamat Pengiriman</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 whitespace-nowrap">Metode Pembayaran</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 text-center whitespace-nowrap">Tgl. Pembelian</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderItems as $index => $item)
                        <tr
                            class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-4 sm:px-6 font-medium text-gray-900 dark:text-white">
                                {{ $orderItems->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $item->order->order_code }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $item->order->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $item->product->name ?? 'Produk Dihapus' }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-center text-gray-900 dark:text-white">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-right text-gray-900 dark:text-white whitespace-nowrap">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-right text-gray-900 dark:text-white whitespace-nowrap">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                            {{-- Perubahan di sini: ditambahkan whitespace-nowrap pada <td> untuk Status Bayar --}}
                            <td class="px-4 py-4 sm:px-6 text-center whitespace-nowrap">
                                @if (strtolower($item->order->status) == 'pending')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full dark:bg-red-900 dark:text-red-300">Belum
                                        Dibayar</span>
                                @elseif(strtolower($item->order->status) == 'paid' ||
                                        strtolower($item->order->status) == 'completed' ||
                                        strtolower($item->order->status) == 'delivered')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full dark:bg-green-900 dark:text-green-300">Sudah
                                        Dibayar</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full dark:bg-gray-900 dark:text-gray-300">{{ Str::ucfirst($item->order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-white text-xs max-w-xs truncate"
                                title="{{ $item->order->shipping_address }}">
                                {{ Str::limit($item->order->shipping_address, 40) }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-white whitespace-nowrap">
                                @if (strtolower($item->order->payment_method) == 'cash')
                                    Tunai
                                @elseif (strtolower($item->order->payment_method) == 'installment')
                                    Cicil @if ($item->order->installment_plan)
                                        ({{ $item->order->installment_plan }})
                                    @endif
                                @else
                                    {{ Str::ucfirst($item->order->payment_method) }}
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-center text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $item->order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-center whitespace-nowrap">
                                @if (strtolower($item->order->status) === 'pending')
                                    <button wire:click="markAsPaid({{ $item->order->id }})"
                                        class="px-3 py-1.5 text-xs font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 dark:focus:ring-green-800">
                                        Tandai Lunas
                                    </button>
                                @else
                                    - {{-- Tidak ada aksi jika sudah bukan pending --}}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                            <td colspan="12" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data pesanan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                {{-- Footer tabel tidak perlu diubah karena sudah mengakomodasi kolom --}}
            </table>
        </div>

        {{-- Paginasi --}}
        @if ($orderItems->hasPages())
            <div class="mt-6">
                {{ $orderItems->links() }}
            </div>
        @endif
    </div>
</div>
