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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('wallet_id')->constrained();
            $table->foreignId('booking_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2);
            $table->string('type'); // payment, refund
            $table->string('status'); // pending, completed, failed
            $table->string('provider'); // vodacom, airtel, halotel, mixx
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
