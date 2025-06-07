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

        {{-- Kontrol Atas Tabel: Filter, Pencarian, dan Tombol Ekspor --}}
        <div class="mb-6 space-y-4">
            {{-- Baris Pertama: Pencarian dan Tombol Ekspor --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                {{-- Input Pencarian --}}
                <div class="relative w-full sm:w-auto sm:max-w-xs">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="search" id="sales_search"
                        class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Cari penjualan...">
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

            {{-- Baris Kedua: Filter-filter --}}
            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    {{-- Filter Periode Utama --}}
                    <div>
                        <label for="filterPeriod"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Periode</label>
                        <select wire:model.live="filterPeriod" id="filterPeriod"
                            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="today">Hari Ini</option>
                            <option value="weekly">Minggu Ini</option>
                            <option value="monthly">Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="annual">Tahun Ini</option>
                            <option value="custom">Pilih Bulan & Tahun</option>
                        </select>
                    </div>

                    {{-- Filter Bulan & Tahun (Kondisional) --}}
                    @if ($filterPeriod === 'custom')
                        {{-- Filter Bulan --}}
                        <div x-data x-transition>
                            <label for="filterMonth"
                                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Bulan</label>
                            <select wire:model.live="filterMonth" id="filterMonth"
                                class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Semua Bulan</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">
                                        {{ \Carbon\Carbon::create()->month($month)->locale('id')->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Filter Tahun --}}
                        <div x-data x-transition>
                            <label for="filterYear"
                                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                            <select wire:model.live="filterYear" id="filterYear"
                                class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Semua Tahun</option>
                                @for ($year = date('Y'); $year >= date('Y') - 4; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    @endif

                    {{-- Filter Metode Pembayaran --}}
                    <div>
                        <label for="filterPaymentMethod"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Pembayaran</label>
                        <select wire:model.live="filterPaymentMethod" id="filterPaymentMethod"
                            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Semua Metode</option>
                            <option value="cash">Tunai</option>
                            <option value="installment">Cicilan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel dan Paginasi (kode ini tetap sama seperti sebelumnya) --}}
        <div
            class="relative overflow-x-auto hide-scrollbar shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-10 sm:w-16">No.</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Kode Transaksi</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Produk</th>
                        <th scope="col" class="px-6 py-3 text-center">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-right whitespace-nowrap">Total Harga Item</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">Tanggal Penjualan</th>
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
                                {{ optional($item->order)->order_code }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">
                                {{ optional($item->product)->name }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-white">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-gray-900 dark:text-white whitespace-nowrap">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">
                                @if (strtolower(optional($item->order)->payment_method) == 'cash')
                                    Tunai
                                @elseif (strtolower(optional($item->order)->payment_method) == 'installment')
                                    Cicil @if (optional($item->order)->installment_plan)
                                        ({{ optional($item->order)->installment_plan }})
                                    @endif
                                @else
                                    {{ Str::ucfirst(optional($item->order)->payment_method) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-white whitespace-nowrap">
                                {{ optional($item->order)->created_at->locale('id')->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700">
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data penjualan untuk filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if (!$salesItems->isEmpty())
                    <tfoot class="font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr class="border-t-2 border-gray-300 dark:border-gray-700">
                            <th scope="row" colspan="3"
                                class="text-right px-6 py-3 text-base whitespace-nowrap">
                                TOTAL KESELURUHAN:</th>
                            <td class="px-6 py-3 text-center text-base whitespace-nowrap">
                                {{ number_format($totalProductsSold, 0, ',', '.') }} unit</td>
                            <td class="px-6 py-3 text-right text-base whitespace-nowrap">Rp
                                {{ number_format($totalSalesRevenue, 0, ',', '.') }}</td>
                            <td class="px-6 py-3" colspan="2"></td> {{-- colspan="2" untuk mengakomodasi 2 kolom sisa --}}
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
        @if ($salesItems->hasPages())
            <div class="mt-6">
                {{ $salesItems->links() }}
            </div>
        @endif
    </div>
</div>
