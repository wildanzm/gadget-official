<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
#[Title('Penjualan')]

class Sale extends Component
{
    use WithPagination;

    public string $filterPeriod = 'monthly'; // Pilihan: 'daily', 'weekly', 'monthly', 'annual'
    public $salesData;
    public int $totalProductsSold = 0;
    public float $totalSalesRevenue = 0;

    public function mount()
    {
        $this->loadSalesData();
    }

    public function updatedFilterPeriod()
    {
        $this->resetPage(); // Reset paginasi saat filter berubah
        $this->loadSalesData();
    }

    public function loadSalesData()
    {
        $query = OrderItem::with(['order', 'product'])
            ->whereHas('order', function ($q_order) {
                // Filter hanya pesanan yang sudah dianggap selesai/valid untuk penjualan
                // Sesuaikan status ini dengan alur bisnis Anda
                // $q_order->whereIn('status', ['completed', 'paid', 'delivered']);

                switch ($this->filterPeriod) {
                    case 'today':
                        $q_order->whereDate('created_at', Carbon::today());
                        break;
                    case 'weekly':
                        $q_order->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'monthly':
                        $q_order->whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month);
                        break;
                    case 'annual':
                        $q_order->whereYear('created_at', Carbon::now()->year);
                        break;
                }
            });

        $this->salesData = $query->get(); // Jika tidak ingin paginasi untuk summary, atau paginate jika data banyak

        // Untuk paginasi pada tabel, Anda bisa melakukan query lagi dengan paginate:
        // $this->paginatedSalesData = $query->latest('orders.created_at')->paginate(10);
        // Namun untuk kemudahan, kita akan paginate hasil $this->salesData di view jika diperlukan,
        // atau langsung $this->salesData = $query->latest('orders.created_at')->paginate(10);
        // dan summary dihitung dari semua data periode tersebut (bukan hanya halaman saat ini).
        // Mari kita hitung summary dari semua data periode yang difilter:
        $allSalesDataForPeriod = $query->get();

        $this->totalProductsSold = $allSalesDataForPeriod->sum('quantity');
        $this->totalSalesRevenue = $allSalesDataForPeriod->sum(function ($item) {
            return $item->price * $item->quantity; // price dari order_items adalah harga saat penjualan
        });

        // Untuk tampilan tabel dengan paginasi
        // Jika Anda ingin summary dihitung dari semua data, namun tabel dipaginasi,
        // Anda perlu dua kueri atau memanipulasi koleksi.
        // Untuk contoh ini, kita akan memaginasi $this->salesData langsung
        // Jika Anda menggunakan get() di atas, dan ingin paginasi di view,
        // Anda perlu implementasi paginasi manual atau gunakan $query->paginate() dan hitung ulang summary.
        // Cara paling mudah:
        // $this->salesData = $query->latest('orders.created_at')->paginate(10); // Untuk tabel
        // Lalu total dihitung dari $query tanpa paginate. Untuk contoh ini, kita sederhanakan:
        // $this->salesData akan di-loop, dan summary sudah dihitung dari $allSalesDataForPeriod

    }

    public function setFilterPeriod(string $period)
    {
        $this->filterPeriod = $period;
        $this->updatedFilterPeriod(); // Memanggil method untuk me-load ulang dan mereset paginasi
    }

    public function exportPdf()
    {
        // Logika untuk ekspor PDF akan ada di sini.
        // Anda memerlukan library seperti DomPDF atau Snappy.
        // Contoh: return (new SalesReportPdf($this->salesData, $this->totalProductsSold, $this->totalSalesRevenue))->download('laporan-penjualan.pdf');
        session()->flash('info', 'Fitur Ekspor PDF sedang dalam pengembangan.');
    }

    public function render()
    {
        // Data sudah di-load oleh mount() atau updatedFilterPeriod()
        // Jika ingin data selalu fresh pada setiap render (misalnya ada polling), panggil loadSalesData() di sini.
        // Untuk paginasi, kita akan melakukan query lagi dengan paginasi di sini

        $query = OrderItem::with(['order', 'product'])
            ->whereHas('order', function ($q_order) {
                // $q_order->whereIn('status', ['completed', 'paid', 'delivered']); // Filter status
                switch ($this->filterPeriod) {
                    case 'today':
                        $q_order->whereDate('created_at', Carbon::today());
                        break;
                    case 'weekly':
                        $q_order->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'monthly':
                        $q_order->whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month);
                        break;
                    case 'annual':
                        $q_order->whereYear('created_at', Carbon::now()->year);
                        break;
                }
            });

        // Data untuk tabel dengan paginasi
        $paginatedSalesItems = $query->orderByDesc(
            Order::select('created_at')
                ->whereColumn('id', 'order_items.order_id')
                ->latest()
                ->limit(1)
        )->paginate(10); // Sesuaikan jumlah per halaman


        return view('livewire.admin.sale', [
            'salesItems' => $paginatedSalesItems, // Data untuk tabel
            // totalProductsSold dan totalSalesRevenue sudah jadi public property
        ]);
    }
}
