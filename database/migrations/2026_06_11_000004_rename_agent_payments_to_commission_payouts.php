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
        Schema::table('agent_payments', function (Blueprint $table) {
            $table->renameColumn('agent_id', 'user_id');
        });

        Schema::rename('agent_payments', 'commission_payouts');

        Schema::table('commission_payouts', function (Blueprint $table) {
            // Payouts are now per-user lump sums against the accrued balance;
            // booking_id remains only as an optional legacy reference.
            $table->foreignId('booking_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commission_payouts', function (Blueprint $table) {
            $table->foreignId('booking_id')->nullable(false)->change();
        });

        Schema::rename('commission_payouts', 'agent_payments');

        Schema::table('agent_payments', function (Blueprint $table) {
            $table->renameColumn('user_id', 'agent_id');
        });
    }
};
