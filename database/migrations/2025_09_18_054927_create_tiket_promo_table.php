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
        Schema::create('tiket_promo', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('promo_id')->constrained('promo')->onDelete('cascade');
            $table->foreignUuid('ticket_id')->constrained('ticket')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_promo');
    }
};
