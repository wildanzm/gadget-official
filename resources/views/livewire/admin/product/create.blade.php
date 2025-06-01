<div>
    <div>
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tambah Produk Baru</h1>
                {{-- Asumsi Anda memiliki route untuk kembali ke daftar produk --}}
                <a href="{{ route('admin.product.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    &larr; Kembali ke Daftar Produk
                </a>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="saveProduct" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                {{-- Nama Produk --}}
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Produk</label>
                    <input type="text" id="name" wire:model.live.debounce.300ms="name" {{-- wire:model.live agar slug terupdate real-time --}}
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan nama produk">
                    @error('name')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Harga Produk --}}
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                        <input type="number" id="price" wire:model.lazy="price" step="any"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Contoh: 1500000">
                        @error('price')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Stok Produk --}}
                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                        <input type="number" id="stock" wire:model.lazy="stock"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Contoh: 100">
                        @error('stock')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi Produk --}}
                <div>
                    <label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="description" wire:model.lazy="description" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Tulis deskripsi produk di sini..."></textarea>
                    @error('description')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Gambar Produk --}}
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar
                        Produk</label>
                    <input type="file" id="image" wire:model="image" accept="image/*"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">

                    <div wire:loading wire:target="image" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Mengunggah gambar...</div>

                    @if ($image && method_exists($image, 'temporaryUrl'))
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Preview Gambar:</p>
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview Gambar Produk"
                                class="max-h-48 w-auto rounded-lg border dark:border-gray-600">
                        </div>
                    @endif
                    @error('image')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end pt-4">
                    <button type="submit" wire:loading.attr="disabled" wire:target="saveProduct"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-75 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        <span wire:loading.remove wire:target="saveProduct">Simpan Produk</span>
                        <span wire:loading wire:target="saveProduct">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
