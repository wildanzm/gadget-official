<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;


#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public float $totalMonthlySales = 0;
    public int $totalProducts = 0;
    public int $totalMonthlyTransactions = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Daftar status pesanan yang dianggap sebagai penjualan yang sah (lunas/selesai)
        $validSaleStatuses = ['paid', 'processing', 'shipped', 'delivered', 'completed'];

        // 1. Total Penjualan Bulanan (DIperbaiki)
        // Kita akan join tabel orders dan order_items, lalu menjumlahkan (harga * kuantitas)
        $totalSales = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->whereYear('orders.created_at', $currentYear)
            ->whereMonth('orders.created_at', $currentMonth)
            ->whereIn('orders.status', $validSaleStatuses)
            ->sum(DB::raw('order_items.price * order_items.quantity')); // Menjumlahkan hasil perkalian

        $this->totalMonthlySales = $totalSales;

        // 2. Jumlah Total Produk yang Dimiliki (Tetap sama)
        $this->totalProducts = Product::count();

        // 3. Jumlah Transaksi Bulanan (Tetap sama, tapi pastikan filternya benar)
        $this->totalMonthlyTransactions = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            //->whereIn('status', $validSaleStatuses)
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
