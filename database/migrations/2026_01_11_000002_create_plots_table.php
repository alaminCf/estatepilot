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
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('plot_no')->unique();
            $table->decimal('size_katha', 8, 2);
            $table->string('block');
            $table->string('road_no');
            $table->string('facing');
            $table->string('agent_name')->nullable();
            $table->string('plot_category')->nullable();
            $table->string('road_width')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('booking_payment', 12, 2);
            $table->decimal('remaining_payment', 12, 2);
            $table->enum('installment_plan', ['monthly', 'quarterly'])->nullable();
            $table->integer('total_installments')->nullable();
            $table->decimal('installment_payment', 12, 2)->nullable();
            $table->string('plot_map')->nullable();
            $table->text('google_maps_location')->nullable();
            $table->text('nearby_facilities')->nullable();
            $table->enum('status', ['available', 'pending', 'booked', 'sold'])->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
