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
        Schema::table('plots', function (Blueprint $table) {
            $table->decimal('booking_payment', 12, 2)->nullable()->default(0)->change();
            $table->decimal('remaining_payment', 12, 2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->decimal('booking_payment', 12, 2)->nullable(false)->default(null)->change();
            $table->decimal('remaining_payment', 12, 2)->nullable(false)->default(null)->change();
        });
    }
};
