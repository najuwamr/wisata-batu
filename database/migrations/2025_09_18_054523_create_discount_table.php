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
        Schema::create('promo', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category',['periodik', 'nonperiodik']);
            $table->integer('discount_percent');
            $table->integer('max_disc_amount')->nullable(); // jumlah diskon maksimal
            $table->datetime('start_date'); //periode promo dari tanggal ...
            $table->datetime('end_date'); //periode promo sampai tanggal ...
            $table->integer('total_qty')->nullable(); // harus diisi jika nonperiodik
            $table->integer('used_qty')->nullable(); // menghitung jumlah promo yang sudah digunakan
            $table->integer('reserved_qty')->nullable(); // menghitung jumlah promo yang sudah digunakan
            $table->integer('daily_qty')->nullable(); // harus diisi jika nonperiodik
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};
