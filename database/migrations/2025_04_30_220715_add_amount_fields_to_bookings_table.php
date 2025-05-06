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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('delivery_fee');
            $table->json('selected_items')->nullable()->after('total_amount');
            $table->string('status')->default('pending')->after('selected_items');
            $table->string('payment_status')->default('pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'total_amount',
                'selected_items',
                'status',
                'payment_status'
            ]);
        });
    }
};
