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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer')->onDelete('cascade');
            $table->string('order_code')->unique(); // kode internal (ORD-2025-001)
            $table->string('midtrans_order_id')->nullable(); // order_id dari Midtrans
            $table->string('midtrans_transaction_id')->nullable(); // transaction_id Midtrans
            $table->decimal('amount', 12, 2); // total harga
            $table->string('payment_type')->nullable(); // VA, QRIS, Gopay, dll
            $table->enum('status', ['pending','paid','cancelled','expired'])->default('pending');
            $table->timestamp('expires_at')->nullable(); // batas waktu bayar
            $table->timestamp('paid_at')->nullable(); // kapan dibayar
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
