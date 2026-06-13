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
        Schema::table('users', function (Blueprint $table) {
            // ed | gm | agm | manager | ast_manager (validated against config('commission.types'))
            $table->string('commission_type', 20)->nullable()->index()->after('role');
            $table->foreignId('parent_id')->nullable()->after('commission_type')->constrained('users')->nullOnDelete();
            // Per-user override percentages; defaults come from config('commission.types.*.defaults')
            $table->decimal('booking_pct', 5, 2)->nullable()->after('commission_rate');
            $table->decimal('down_pct', 5, 2)->nullable()->after('booking_pct');
            $table->decimal('instalment_pct', 5, 2)->nullable()->after('down_pct');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropColumn(['commission_type', 'booking_pct', 'down_pct', 'instalment_pct']);
        });
    }
};
