<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('order_code')->unique(); // Kode unik untuk setiap pesanan
            $table->decimal('total_amount', 15, 2);
            $table->string('status')->default('pending'); // Contoh: pending, processing, shipped, completed, cancelled
            $table->text('shipping_address');
            $table->string('payment_method'); // Contoh: cash, credit_card, bank_transfer
            $table->string('installment_plan')->nullable(); // Contoh: 3_months, 6_months, 12_months, atau null jika tunai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
