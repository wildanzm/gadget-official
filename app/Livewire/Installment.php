<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Installment extends Component
{
    use WithPagination;

    public int $perPage = 5; // Jumlah pesanan per halaman

    public function render()
    {
        $ordersQuery = Order::with(['items.product', 'installments'])
            ->where('user_id', Auth::id())
            ->where('payment_method', 'installment')
            ->whereHas('installments') // Hanya tampilkan order yang punya data cicilan
            ->orderBy('created_at', 'desc');

        $orders = $ordersQuery->paginate($this->perPage);

        // Menambahkan properti denda pada setiap item cicilan untuk ditampilkan di view
        $orders->getCollection()->transform(function ($order) {
            if ($order->installments) {
                $order->installments->transform(function ($installment) {
                    $installment->late_fee = 0;
                    $installment->late_days = 0;

                    $dueDate = Carbon::parse($installment->due_date)->startOfDay();
                    $today = Carbon::now()->startOfDay();

                    // Hitung denda jika cicilan BELUM LUNAS dan HARI INI sudah melewati jatuh tempo
                    if (!$installment->is_paid && $today->gt($dueDate)) {
                        $lateDays = $today->diffInDays($dueDate);
                        if ($lateDays > 0) {
                            $installment->late_days = $lateDays;
                            // Denda 1% dari jumlah cicilan, dikalikan jumlah hari keterlambatan
                            $installment->late_fee = ($installment->amount * 0.01) * $lateDays;
                        }
                    }
                    return $installment;
                });
            }
            return $order;
        });

        return view('livewire.installment', [
            'orders' => $orders,
        ]);
    }
}
