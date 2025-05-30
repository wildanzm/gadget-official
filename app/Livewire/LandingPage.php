<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
#[Title('Home')]

class LandingPage extends Component
{
    use WithPagination;

    public int $perPage = 10; // Jumlah produk per halaman (jika menggunakan paginasi)
    // Anda bisa menambahkan properti lain seperti filter, sorting, dll.

    /**
     * Metode untuk menambahkan produk ke keranjang.
     * Implementasi sebenarnya akan bergantung pada sistem keranjang Anda.
     */
    public function addToCart($productId)
    {
        // Logika untuk menambahkan produk ke keranjang
        // Contoh: Cart::add($productId, ...);
        // session()->flash('message', 'Produk ditambahkan ke keranjang!');
        $this->dispatch('productAddedToCart', ['productId' => $productId]); // Emit event
        // dd('Produk ID ' . $productId . ' ditambahkan ke keranjang.'); // Untuk debugging
    }

    public function render()
    {
        // Ambil produk dari database. Contoh: 10 produk terbaru dengan paginasi.
        // Sesuaikan kueri ini dengan kebutuhan Anda (misalnya, produk unggulan, produk diskon, dll.)
        $products = Product::latest() // Urutkan berdasarkan terbaru
            // ->where('is_featured', true) // Contoh filter
            ->paginate($this->perPage);

        return view('livewire.landing-page', [ // Pastikan nama view ini sesuai
            'products' => $products,
        ]);
    }
}
