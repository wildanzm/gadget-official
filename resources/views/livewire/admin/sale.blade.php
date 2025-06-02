<div>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        {{-- Judul Halaman --}}
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Data Penjualan</h1>
        </div>

        @if (session()->has('info'))
            <div class="mb-4 p-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-900 dark:text-blue-300"
                role="alert">
                {{ session('info') }}
            </div>
        @endif

        {{-- Kontrol Atas Tabel: Filter dan Tombol Ekspor --}}
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            {{-- Filter Periode Dropdown --}}
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <label for="filterPeriod" class="text-sm font-medium text-gray-700 dark:text-gray-300 shrink-0">Filter
                    Periode:</label>
                <select wire:model.live="filterPeriod" id="filterPeriod"
                    class="block w-full sm:w-auto p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                           focus:ring-blue-500 focus:border-blue-500 
                           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                           dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="today">Hari Ini</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                    <option value="annual">Tahunan</option>
                </select>
            </div>

            {{-- Tombol Ekspor PDF --}}
            <button wire:click="exportPdf" type="button"
                class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-700 dark:focus:ring-red-900 disabled:opacity-50 whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Ekspor PDF
            </button>
        </div>

        {{-- Kontainer Tabel --}}
        {{-- `overflow-x-auto` sudah ada di sini dan ini adalah cara yang benar untuk menangani tabel lebar --}}
        <div class="relative overflow-x-auto hide-scrollbar shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-10 sm:w-16">No.</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Kode Transaksi</th> {{-- Ditambahkan whitespace-nowrap --}}
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Produk</th> {{-- Ditambahkan whitespace-nowrap --}}
                        <th scope="col" class="px-6 py-3 text-center">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-right whitespace-nowrap">Total Harga Item</th>
                        {{-- Ditambahkan whitespace-nowrap --}}
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Metode Pembayaran</th>
                        {{-- Ditambahkan whitespace-nowrap --}}
                        <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">Tanggal Penjualan</th>
                        {{-- Ditambahkan whitespace-nowrap --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salesItems as $index => $item)
                        <tr
                            class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/70">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $salesItems->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{-- Ditambahkan whitespace-nowrap --}}
                                {{ $item->order->order_code }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">
                                {{-- Ditambahkan whitespace-nowrap --}}
                                {{ $item->product->name }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-white">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-gray-900 dark:text-white whitespace-nowrap">
                                {{-- Ditambahkan whitespace-nowrap --}}
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">
                                {{-- Ditambahkan whitespace-nowrap --}}
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
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-white whitespace-nowrap">
                                {{-- Ditambahkan whitespace-nowrap --}}
                                {{ $item->order->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data penjualan untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if (!$salesItems->isEmpty())
                    <tfoot class="font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr class="border-t-2 border-gray-300 dark:border-gray-700">
                            <th scope="row" colspan="3" class="text-right px-6 py-3 text-base whitespace-nowrap">
                                TOTAL KESELURUHAN:</th> {{-- Ditambahkan whitespace-nowrap --}}
                            <td class="px-6 py-3 text-center text-base whitespace-nowrap">
                                {{ number_format($totalProductsSold, 0, ',', '.') }} unit</td> {{-- Ditambahkan whitespace-nowrap --}}
                            <td class="px-6 py-3 text-right text-base whitespace-nowrap">Rp
                                {{ number_format($totalSalesRevenue, 0, ',', '.') }}</td> {{-- Ditambahkan whitespace-nowrap --}}
                            <td class="px-6 py-3"></td>
                            <td class="px-6 py-3"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        {{-- Paginasi --}}
        @if ($salesItems->hasPages())
            <div class="mt-6">
                {{ $salesItems->links() }}
            </div>
        @endif
    </div>
</div>
