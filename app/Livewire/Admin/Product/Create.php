<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
#[Title('Tambah Produk')]

class Create extends Component
{

    use WithFileUploads;

    public $name;
    public $slug; // Properti slug tetap ada untuk diisi otomatis
    public $price;
    public $stock;
    public $description;
    public $image;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    protected $messages = [
        'name.required' => 'Nama produk wajib diisi.',
        'slug.required' => 'Slug produk gagal dibuat secara otomatis.', // Pesan jika slug kosong saat validasi
        'slug.unique' => 'Slug ini sudah ada dari produk lain, coba ubah sedikit nama produknya.',
        'price.required' => 'Harga produk wajib diisi.',
        'price.numeric' => 'Harga produk harus berupa angka.',
        'stock.required' => 'Jumlah stok wajib diisi.',
        'stock.integer' => 'Jumlah stok harus berupa angka bulat.',
        'image.image' => 'File yang diunggah harus berupa gambar.',
        'image.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function mount()
    {
        $this->price = 0;
        $this->stock = 0;
    }

    /**
     * Auto-generate slug ketika nama produk diubah.
     * Dipicu jika input nama menggunakan wire:model.live atau wire:model.blur
     */
    public function updatedName($value)
    {
        if (!empty($value)) {
            $this->slug = Str::slug($value);
        } else {
            $this->slug = null; // Kosongkan slug jika nama kosong
        }
    }

    public function saveProduct()
    {
        // Pastikan slug di-generate dari nama produk sebelum validasi,
        // terutama jika input nama tidak menggunakan .live atau .blur, atau jika slug kosong.
        if (!empty($this->name)) {
            $this->slug = Str::slug($this->name);
        } else {
            // Jika nama kosong, slug juga harus dianggap kosong agar validasi 'slug.required' bisa relevan
            // Namun, 'name.required' akan lebih dulu gagal.
            $this->slug = null;
        }

        $validatedData = $this->validate();

        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            unset($validatedData['image']);
        }

        Product::create($validatedData);

        session()->flash('message', 'Produk baru berhasil ditambahkan!');

        $this->reset(['name', 'slug', 'price', 'stock', 'description', 'image']);
        $this->price = null;
        $this->stock = null;

        return redirect()->route('admin.product.index');
    }

    public function render()
    {
        return view('livewire.admin.product.create');
    }
}
