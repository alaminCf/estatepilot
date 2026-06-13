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
        Schema::create('commission_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            // Beneficiary of this earning row
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // The commission user who made the sale (level 0 row has user_id = seller_id)
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('level'); // 0 = seller, 1 = immediate upline, ...
            $table->string('beneficiary_type', 20); // commission_type snapshot at earn time
            $table->string('pool_type', 20); // booking | down | instalment
            $table->decimal('pool_rate', 5, 2); // pool total % snapshot (50/20/15)
            $table->decimal('percentage', 5, 2); // this beneficiary's share % of the payment amount
            $table->decimal('amount', 12, 2);
            $table->timestamps();

            $table->index(['user_id', 'pool_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_earnings');
    }
};
