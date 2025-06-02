<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
#[Title('Daftar Transaksi')]
class Transaction extends Component
{
    use WithPagination;

    public int $perPage = 5; // Jumlah transaksi per halaman

    /**
     * Metode untuk mencetak invoice.
     * Implementasi sebenarnya akan bergantung pada library PDF atau cara Anda generate invoice.
     */
    public function printInvoice($orderId)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('user_id', Auth::id())
            ->where('id', $orderId)
            ->firstOrFail();

        // Logika untuk generate dan download PDF invoice
        // Contoh: return response()->streamDownload(function () use ($order) {
        //     $pdf = \PDF::loadView('invoices.transaction', ['order' => $order]);
        //     echo $pdf->stream();
        // }, 'invoice-' . $order->order_code . '.pdf');

        session()->flash('info', 'Fitur cetak invoice untuk pesanan ' . $order->order_code . ' sedang dalam pengembangan.');
        // Atau redirect ke halaman invoice yang bisa di-print
        // return redirect()->route('user.invoice.show', $order->order_code);
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product']) // Eager load order items dan produk terkait
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.transaction', [
            'orders' => $orders,
        ]);
    }
}
