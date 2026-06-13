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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('referral_agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('additional_info')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('booking_payment', 15, 2);
            $table->decimal('remaining_payment', 15, 2);
            $table->enum('installment_plan', ['monthly', 'quarterly'])->nullable();
            $table->integer('total_installments')->nullable();
            $table->decimal('installment_payment', 15, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'approved', 'cancelled'])->default('pending');
            $table->timestamp('booking_date')->nullable();
            $table->timestamp('agent_changed_at')->nullable();
            $table->decimal('agent_commission_base_paid', 15, 2)->nullable();
            $table->decimal('agent_commission', 5, 2)->nullable();
            $table->json('owners')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
