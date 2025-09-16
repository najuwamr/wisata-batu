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
        Schema::create('ticket_type', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Reguler, VIP, Anak-anak
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('quota')->nullable(); // stok tiket (NULL = unlimited)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_type');
    }
};
