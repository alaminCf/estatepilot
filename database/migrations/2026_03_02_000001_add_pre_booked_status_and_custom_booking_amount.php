<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update status enum to include 'pre-booked'
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'confirmed', 'approved', 'cancelled', 'pre-booked') DEFAULT 'pending'");

        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('custom_booking_amount', 15, 2)->nullable()->after('booking_payment');
            $table->timestamp('pre_booking_expires_at')->nullable()->after('booking_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['custom_booking_amount', 'pre_booking_expires_at']);
        });

        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'confirmed', 'approved', 'cancelled') DEFAULT 'pending'");
    }
};
