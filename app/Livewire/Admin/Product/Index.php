<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.admin')]
#[Title('Produk')]

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    // Properti untuk modal dan data terkait
    public bool $showEditModal = false;
    public bool $showDeleteConfirmationModal = false;

    public ?Product $editingProduct = null; // Untuk menyimpan data produk yang akan diedit
    public ?Product $productToDelete = null; // Untuk menyimpan produk yang akan dihapus

    // Properti untuk form edit (jika form edit ada di komponen ini)
    public $editForm = [
        'name' => '',
        'slug' => '', // Slug mungkin tidak diedit atau di-generate ulang
        'price' => 0,
        'stock' => 0,
        'description' => '',
        // image tidak di-handle di sini, perlu perlakuan khusus jika mau update image
    ];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'perPage' => ['except' => 10, 'as' => 'limit'],
    ];

    // Aturan validasi untuk form edit
    protected function editRules(): array
    {
        return [
            'editForm.name' => ['required', 'string', 'max:255'],
            'editForm.price' => ['required', 'numeric', 'min:0'],
            'editForm.stock' => ['required', 'integer', 'min:0'],
            'editForm.description' => ['nullable', 'string'],
            // Validasi slug jika diizinkan untuk diubah dan harus unik kecuali untuk produk itu sendiri
            // 'editForm.slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $this->editingProduct?->id],
        ];
    }

    public function openEditModal(Product $product)
    {
        $this->editingProduct = $product;
        $this->editForm = [
            'name' => $product->name,
            'slug' => $product->slug, // Biasanya slug tidak diubah, atau di-handle hati-hati
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
        ];
        $this->showEditModal = true;
    }

    public function updateProduct()
    {
        if (!$this->editingProduct) {
            return;
        }

        $validatedData = $this->validate($this->editRules())['editForm'];

        // Jika slug di-generate dari nama dan nama berubah
        // if ($this->editingProduct->name !== $validatedData['name']) {
        //     $validatedData['slug'] = \Illuminate\Support\Str::slug($validatedData['name']);
        // }

        $this->editingProduct->update($validatedData);

        $this->showEditModal = false;
        $this->editingProduct = null;
        session()->flash('message', 'Produk berhasil diperbarui.');
    }

    public function confirmDelete(Product $product)
    {
        $this->productToDelete = $product;
        $this->showDeleteConfirmationModal = true;
    }

    public function deleteProduct()
    {
        if ($this->productToDelete) {
            // Hapus gambar terkait jika ada sebelum menghapus produk
            if ($this->productToDelete->image) {
                Storage::disk('public')->delete($this->productToDelete->image);
            }
            $this->productToDelete->delete();
            session()->flash('message', 'Produk berhasil dihapus.');
        }
        $this->showDeleteConfirmationModal = false;
        $this->productToDelete = null;
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%'); // Tambah pencarian deskripsi
            })
            // ->with('category') // Dihapus karena tidak ada kategori di tabel SQL produk Anda
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.product.index', [ // Pastikan nama view Anda benar
            'products' => $products,
        ]);
    }
}