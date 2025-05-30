<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;


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

        // 1. Total Penjualan Bulanan
        // Anda mungkin ingin menambahkan filter status, e.g., ->where('status', 'completed')
        $this->totalMonthlySales = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            // ->whereIn('status', ['completed', 'paid', 'delivered']) // Contoh filter status
            ->sum('total_amount');

        // 2. Jumlah Produk yang Dimiliki
        $this->totalProducts = Product::count();

        // 3. Jumlah Transaksi Bulanan
        // Anda mungkin ingin menambahkan filter status juga di sini
        $this->totalMonthlyTransactions = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            // ->whereIn('status', ['completed', 'paid', 'delivered']) // Contoh filter status
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
