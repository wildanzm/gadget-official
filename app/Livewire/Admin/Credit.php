<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Installment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin')]
#[Title('Daftar Tagihan Kredit - Gadget Official')]
class Credit extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public string $filterStatus = '';

    public function mount()
    {
        // Inisialisasi awal jika diperlukan
    }

    public function exportPdf()
    {
        $queryParams = http_build_query([
            'search' => $this->search,
            'status' => $this->filterStatus,
        ]);

        $url = route('admin.credit.stream') . '?' . $queryParams;

        return $this->redirect($url, navigate: false);
    }

    public function markInstallmentAsPaid(int $installmentId)
    {
        DB::transaction(function () use ($installmentId) {
            $installment = Installment::with('order')->lockForUpdate()->find($installmentId);

            if ($installment && !$installment->is_paid) {
                // Logika denda bisa juga dimasukkan di sini sebelum menyimpan
                // jika Anda ingin menyimpan jumlah denda yang dibayarkan ke database

                $installment->is_paid = true;
                $installment->paid_at = Carbon::now();
                $installment->save();

                $order = $installment->order;
                $allInstallmentsPaid = $order->installments()->where('is_paid', false)->doesntExist();

                if ($allInstallmentsPaid) {
                    $order->status = 'completed'; // Atau 'fully_paid'
                    $order->save();
                    session()->flash('message', 'Semua cicilan untuk pesanan ' . $order->order_code . ' telah lunas. Status pesanan diperbarui.');
                } else {
                    session()->flash('message', 'Cicilan untuk pesanan ' . $order->order_code . ' telah ditandai lunas.');
                }
            } else {
                session()->flash('error', 'Tagihan tidak ditemukan atau sudah lunas.');
            }
        });
    }

    public function render()
    {
        $ordersQuery = Order::with(['user', 'items.product', 'installments'])
            ->where('payment_method', 'installment')
            ->when($this->search, function ($query) {
                $query->where('order_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q_user) {
                        $q_user->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterStatus, function ($query) {
                if ($this->filterStatus === 'pending_installments') {
                    $query->whereHas('installments', function ($q_installment) {
                        $q_installment->where('is_paid', false);
                    });
                } elseif ($this->filterStatus === 'fully_paid') {
                    $query->whereDoesntHave('installments', function ($q_installment) {
                        $q_installment->where('is_paid', false);
                    })->whereHas('installments');
                }
            })
            ->orderBy('created_at', 'desc');

        $orders = $ordersQuery->paginate($this->perPage);

        // Menambahkan properti denda pada setiap item cicilan untuk ditampilkan di view
        $orders->getCollection()->transform(function ($order) {
            if ($order->installments) {
                $order->installments->transform(function ($installment) {
                    $installment->late_fee = 0;
                    $installment->late_days = 0;

                    $dueDate = \Carbon\Carbon::parse($installment->due_date)->startOfDay();

                    // --- MANIPULASI WAKTU UNTUK DEBUGGING ---
                    // Anggap saja "hari ini" adalah tanggal tertentu untuk tes
                    // Hapus atau komentari baris ini setelah selesai debugging.
                    $today = \Carbon\Carbon::createFromDate(2025, 5, 10, 'Asia/Jakarta')->startOfDay();
                    // Atau gunakan waktu sekarang dengan timezone yang benar
                    // $today = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();

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

        return view('livewire.admin.credit', [
            'orders' => $orders,
        ]);
    }
}
