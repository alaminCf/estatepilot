<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // 'flat' = legacy single-rate agent commission, 'hierarchy' = commission chart distribution
            $table->string('commission_scheme', 20)->nullable()->index()->after('agent_commission');
        });

        // All pre-existing bookings keep the legacy flat-rate commission behaviour.
        DB::table('bookings')->update(['commission_scheme' => 'flat']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('commission_scheme');
        });
    }
};
