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
            $table->boolean('pickup_required')->default(false)->after('scheduled_time');
            $table->boolean('delivery_required')->default(false)->after('pickup_required');
            $table->decimal('pickup_fee', 10, 2)->default(0.00)->after('delivery_required');
            $table->decimal('delivery_fee', 10, 2)->default(0.00)->after('pickup_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_required',
                'delivery_required',
                'pickup_fee',
                'delivery_fee'
            ]);
        });
    }
};
