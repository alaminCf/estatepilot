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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('emergency_phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('nid', 50)->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_nid', 50)->nullable();
            $table->string('nominee_photo')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->enum('role', ['admin', 'agent', 'user'])->default('user');
            // Commission hierarchy: ed | gm | agm | manager | ast_manager (see config/commission.php)
            $table->string('commission_type', 20)->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->json('permissions')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('commission_rate', 5, 2)->nullable();
            // Per-user override percentages; defaults from config('commission.types.*.defaults')
            $table->decimal('booking_pct', 5, 2)->nullable();
            $table->decimal('down_pct', 5, 2)->nullable();
            $table->decimal('instalment_pct', 5, 2)->nullable();
            $table->string('referral_code')->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
