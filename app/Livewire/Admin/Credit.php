<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use App\Models\Installment;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
#[Title('Tagihan Kredit')]
class Credit extends Component
{
    use WithPagination;

    public int $perPage = 10; // Jumlah order per halaman
    public string $search = '';
    public string $filterStatus = ''; // 'all', 'pending', 'paid'

    // Properti untuk modal atau detail (jika diperlukan)
    // public $selectedOrder;

    public function mount()
    {
        // Inisialisasi
    }

    /**
     * Menandai satu tagihan spesifik sebagai lunas.
     */
    public function markInstallmentAsPaid(int $installmentId)
    {
        $installment = Installment::find($installmentId);
        if ($installment && !$installment->is_paid) {
            $installment->is_paid = true;
            $installment->paid_at = Carbon::now(); // Tambahkan kolom paid_at jika ada
            $installment->save();

            // Cek apakah semua cicilan untuk order ini sudah lunas
            $order = $installment->order;
            $allInstallmentsPaid = $order->installments()->where('is_paid', false)->doesntExist();

            if ($allInstallmentsPaid) {
                $order->status = 'completed'; // Atau 'paid_fully'
                $order->save();
                session()->flash('message', 'Semua cicilan untuk pesanan ' . $order->order_code . ' telah lunas. Status pesanan diperbarui.');
            } else {
                session()->flash('message', 'Cicilan untuk pesanan ' . $order->order_code . ' telah ditandai lunas.');
            }
        } else {
            session()->flash('error', 'Tagihan tidak ditemukan atau sudah lunas.');
        }
    }

    public function render()
    {
        $ordersQuery = Order::with(['user', 'items.product', 'installments'])
            ->where('payment_method', 'installment') // Hanya pesanan cicilan
            ->when($this->search, function ($query) {
                $query->where('order_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q_user) {
                        $q_user->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterStatus, function ($query) {
                if ($this->filterStatus === 'pending_installments') {
                    // Order yang masih memiliki cicilan belum lunas
                    $query->whereHas('installments', function ($q_installment) {
                        $q_installment->where('is_paid', false);
                    });
                } elseif ($this->filterStatus === 'fully_paid') {
                    // Order yang semua cicilannya sudah lunas
                    $query->whereDoesntHave('installments', function ($q_installment) {
                        $q_installment->where('is_paid', false);
                    })->whereHas('installments'); // Pastikan memiliki cicilan
                }
                // Anda bisa menambahkan filter status order utama juga jika perlu, e.g., 'completed', 'cancelled'
            })
            ->orderBy('created_at', 'desc');

        $orders = $ordersQuery->paginate($this->perPage);

        return view('livewire.admin.credit', [
            'orders' => $orders,
        ]);
    }
}
