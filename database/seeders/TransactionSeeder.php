<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('user')->get();
        if ($users->isEmpty()) {
            $this->command->error('Tidak ada user dengan role "user". Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->error('Tidak ada produk di database. Jalankan ProductSeeder terlebih dahulu.');
            return;
        }

        $faker = Faker::create('id_ID');

        $createSuccessfulOrder = function (Carbon $date, $users, $products, bool $isLate = false) use ($faker) {
            DB::transaction(function () use ($date, $users, $products, $isLate, $faker) {

                $randomUser = $users->random();
                $todaysOrderCount = Order::whereDate('created_at', $date)->count();
                $sequenceNumber = str_pad($todaysOrderCount + 1, 3, '0', STR_PAD_LEFT);
                $orderCode = 'GO-' . $date->format('Ymd') . $sequenceNumber;

                $paymentMethod = $isLate ? 'installment' : $faker->randomElement(['cash', 'installment']);
                $installmentPlan = null;
                if ($paymentMethod === 'installment') {
                    $installmentPlan = $faker->randomElement([3, 6, 12]) . ' Bulan';
                }

                $orderStatus = $isLate ? 'delivered' : 'completed';

                $order = Order::create([
                    'user_id' => $randomUser->id,
                    'order_code' => $orderCode,
                    'total_amount' => 0,
                    'status' => $orderStatus,
                    'shipping_address' => $randomUser->address ?? $faker->address(),
                    'payment_method' => $paymentMethod,
                    'installment_plan' => $installmentPlan,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $itemsToOrder = $products->random(rand(1, 3));
                $subTotal = 0;

                foreach ($itemsToOrder as $product) {
                    $quantity = rand(1, 2);
                    $subTotal += $product->price * $quantity;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }

                $interestAmount = ($order->payment_method === 'installment') ? ($subTotal * 0.05) : 0;
                $grandTotal = $subTotal + $interestAmount;

                if (Schema::hasColumn('orders', 'name_receiver')) {
                    $order->name_receiver = $randomUser->name;
                }
                if (Schema::hasColumn('orders', 'sub_total')) {
                    $order->sub_total = $subTotal;
                }
                if (Schema::hasColumn('orders', 'interest_amount')) {
                    $order->interest_amount = $interestAmount;
                }
                $order->total_amount = $grandTotal;
                $order->save();

                if ($order->payment_method === 'installment') {
                    $tenor = (int) $order->installment_plan;
                    $monthlyPayment = $grandTotal / $tenor;
                    $today = Carbon::now(config('app.timezone', 'UTC'))->startOfDay();

                    for ($i = 1; $i <= $tenor; $i++) {

                        $dueDateForThisInstallment = $date->copy()->addMonthsNoOverflow($i)->startOfDay();
                        $isInstallmentPaid = true;
                        $lateDays = 0;
                        $lateFee = 0;

                        if ($isLate) {
                            // Jika jatuh tempo sudah lewat atau hari ini, tandai sebagai belum lunas
                            if ($dueDateForThisInstallment->isPast() || $dueDateForThisInstallment->isToday()) {
                                $isInstallmentPaid = false;

                                // PERBAIKAN: Logika Perhitungan Keterlambatan dan Denda
                                // Cek apakah hari ini sudah benar-benar melewati tanggal jatuh tempo
                                if ($today->isAfter($dueDateForThisInstallment)) {

                                    // Hitung selisih hari sebagai nilai absolut (selalu positif)
                                    $lateDays = $dueDateForThisInstallment->diffInDays($today);

                                    if ($lateDays > 0) {
                                        // Denda 0.1% per hari
                                        $dailyFine = $monthlyPayment * 0.001;
                                        $lateFee = $dailyFine * $lateDays;
                                    }
                                }
                            }

                            // Jika jatuh tempo di masa depan, juga belum lunas tapi tanpa denda
                            if ($dueDateForThisInstallment->isFuture()) {
                                $isInstallmentPaid = false;
                            }
                        }

                        Installment::create([
                            'order_id' => $order->id,
                            'amount' => $monthlyPayment,
                            'due_date' => $dueDateForThisInstallment,
                            'is_paid' => $isInstallmentPaid,
                            'paid_at' => $isInstallmentPaid ? $dueDateForThisInstallment->copy()->subDays(rand(1, 5)) : null,
                            'late_days' => $lateDays,
                            'late_fee' => $lateFee,
                        ]);
                    }
                }
            });
        };

        $this->command->info('Membuat 25 data transaksi untuk April 2025...');
        for ($i = 0; $i < 25; $i++) {
            $date = Carbon::create(2025, 4, rand(1, 30), rand(8, 22), rand(0, 59), rand(0, 59));
            // Teruskan koleksi $users ke dalam fungsi
            $createSuccessfulOrder($date, $users, $products);
        }
        $this->command->info('Data April 2025 selesai dibuat.');

        $this->command->info('Membuat 25 data transaksi untuk Mei 2025...');
        for ($i = 0; $i < 25; $i++) {
            $date = Carbon::create(2025, 5, rand(1, 31), rand(8, 22), rand(0, 59), rand(0, 59));
            // Teruskan koleksi $users ke dalam fungsi
            $createSuccessfulOrder($date, $users, $products);
        }
        $this->command->info('Data Mei 2025 selesai dibuat.');
        $this->command->info('Membuat 25 data transaksi untuk Juni 2025...');
        for ($i = 0; $i < 25; $i++) {
            $date = Carbon::create(2025, 6, rand(1, 16), rand(8, 22), rand(0, 59), rand(0, 59));
            // Teruskan koleksi $users ke dalam fungsi
            $createSuccessfulOrder($date, $users, $products);
        }
        $this->command->info('Data Juni 2025 selesai dibuat.');

        $this->command->info('Membuat 5 data transaksi cicilan yang terlambat...');
        for ($i = 0; $i < 5; $i++) {
            $pastDate = Carbon::now()->subMonths(rand(2, 4))->subDays(rand(1, 20));
            $createSuccessfulOrder($pastDate, $users, $products, true);
        }
        $this->command->info('Data cicilan terlambat selesai dibuat.');
    }
}
