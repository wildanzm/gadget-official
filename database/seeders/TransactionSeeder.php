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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil SEMUA user dengan role 'user'
        $users = User::role('user')->get();
        if ($users->isEmpty()) {
            $this->command->error('Tidak ada user dengan role "user". Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // Ambil produk yang sudah ada
        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->error('Tidak ada produk di database. Jalankan ProductSeeder terlebih dahulu.');
            return;
        }

        $faker = Faker::create('id_ID');

        // Fungsi helper untuk membuat satu pesanan lengkap
        // Sekarang $user akan dipilih secara acak di dalam loop
        $createSuccessfulOrder = function (Carbon $date, $users, $products) use ($faker) {
            DB::transaction(function () use ($date, $users, $products, $faker) {

                // 2. Pilih satu user secara acak dari koleksi
                $randomUser = $users->random();

                $todaysOrderCount = Order::whereDate('created_at', $date)->count();
                $sequenceNumber = str_pad($todaysOrderCount + 1, 3, '0', STR_PAD_LEFT);
                $orderCode = 'GO-' . $date->format('Ymd') . $sequenceNumber;

                $paymentMethod = $faker->randomElement(['cash', 'installment']);
                $installmentPlan = null;
                if ($paymentMethod === 'installment') {
                    $installmentPlan = $faker->randomElement([3, 6, 12]) . ' Bulan';
                }

                $order = Order::create([
                    'user_id' => $randomUser->id, // 3. Gunakan ID user yang random
                    'order_code' => $orderCode,
                    'total_amount' => 0,
                    'status' => 'completed',
                    'shipping_address' => $randomUser->address ?? $faker->address(), // Gunakan alamat user random
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

                if (Schema::hasColumn('orders', 'name_receiver')) { // Cek jika kolom ada
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
                    for ($i = 1; $i <= $tenor; $i++) {
                        Installment::create([
                            'order_id' => $order->id,
                            'amount' => $monthlyPayment,
                            'due_date' => $date->copy()->addMonthsNoOverflow($i),
                            'is_paid' => true,
                            'paid_at' => $date->copy()->addMonthsNoOverflow($i)->subDays(rand(1, 5)),
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
    }
}
