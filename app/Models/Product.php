<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'price',
        'stock',
    ];

    public function getImageUrlAttribute(): string
    {
        // Jika nilai 'image' sudah merupakan URL lengkap (dimulai dengan http:// atau https://)
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image; // Langsung kembalikan URL tersebut
        }

        // Jika 'image' kosong atau null, kembalikan URL gambar placeholder
        if (!$this->image) {
            // Anda bisa menggunakan layanan seperti placehold.co
            return 'https://placehold.co/300x300/e2e8f0/e2e8f0.png?text=No+Image';
        }

        // Jika bukan URL dan tidak kosong, anggap ini adalah path di storage lokal Anda
        // dan gunakan Storage::url() untuk mendapatkan URL publiknya.
        return Storage::url($this->image);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
