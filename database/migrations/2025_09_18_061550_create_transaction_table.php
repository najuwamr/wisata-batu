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
        Schema::create('transaction', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('midtrans_order_id');
            $table->string('midtrans_tr_id')->nullable();
            $table->integer('total_price');
            $table->foreignUuid('customer_id')->constrained('customer')->onDelete('cascade');
            $table->foreignId('payment_methode_id')->constrained('payment_methode')->onDelete('cascade');
            $table->foreignId('status_transaction_id')->constrained('status_transaction')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
