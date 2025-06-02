<?php

namespace App\Livewire\Admin;

use App\Models\Order as OrderModel;
use Livewire\Component;
use App\Models\OrderItem;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.admin')]
#[Title('Daftar Pesanan')]
class Order extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = ''; // Untuk pencarian jika diperlukan nanti

    // Anda bisa menambahkan filter untuk status, tanggal, dll.
    // public $filterStatus = '';

    public function markAsPaid(int $orderId)
    {
        $order = OrderModel::find($orderId);
        if ($order && strtolower($order->status) === 'pending') {
            $order->status = 'paid'; // Atau 'completed', 'processed', dll. sesuai alur Anda
            $order->save();
            session()->flash('message', 'Status pesanan ' . $order->order_code . ' telah diubah menjadi Sudah Dibayar.');
        } else {
            session()->flash('error', 'Pesanan tidak ditemukan atau status tidak bisa diubah.');
        }
        // Tidak perlu me-refresh data secara manual, Livewire akan menangani re-render
    }

    public function render()
    {
        // Mengambil data item pesanan, beserta relasi ke order, user, dan product
        $orderItemsQuery = OrderItem::with(['order.user', 'product'])
            ->select('order_items.*') // Penting jika ada join dengan nama kolom sama
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Join untuk sorting/filtering by order
            ->when($this->search, function ($query) {
                $query->whereHas('order', function ($q_order) {
                    $q_order->where('order_code', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($q_user) {
                            $q_user->where('name', 'like', '%' . $this->search . '%');
                        });
                })
                    ->orWhereHas('product', function ($q_product) {
                        $q_product->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('orders.created_at', 'desc'); // Urutkan berdasarkan tanggal pesanan terbaru

        $orderItems = $orderItemsQuery->paginate($this->perPage);

        return view('livewire.admin.order', [
            'orderItems' => $orderItems,
        ]);
    }
}