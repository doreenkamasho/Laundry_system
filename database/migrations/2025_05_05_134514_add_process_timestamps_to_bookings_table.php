<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('washing_started_at')->nullable();
            $table->timestamp('drying_started_at')->nullable();
            $table->timestamp('ironing_started_at')->nullable();
            $table->timestamp('packaging_started_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'washing_started_at',
                'drying_started_at',
                'ironing_started_at',
                'packaging_started_at'
            ]);
        });
    }
};