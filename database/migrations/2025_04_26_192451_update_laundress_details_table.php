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
        Schema::table('laundress_details', function (Blueprint $table) {
            // Remove unnecessary columns
            $table->dropColumn(['experience', 'specialization']);
            
            // Add location columns
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('current_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laundress_details', function (Blueprint $table) {
            // Restore removed columns
            $table->text('experience')->nullable();
            $table->string('specialization')->nullable();
            
            // Remove location columns
            $table->dropColumn(['latitude', 'longitude', 'current_location']);
        });
    }
};
