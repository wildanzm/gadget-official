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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->decimal('amount', 15, 2); // Jumlah cicilan per periode
            $table->date('due_date'); // Tanggal jatuh tempo cicilan
            $table->boolean('is_paid')->default(false); // Status pembayaran cicilan
            $table->timestamp('paid_at')->nullable(); // Status pembayaran cicilan
            $table->integer('late_days')->default(0);
            $table->decimal('late_fee', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
