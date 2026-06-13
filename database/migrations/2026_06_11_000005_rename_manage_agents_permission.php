<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->renamePermission('manage_agents', 'manage_commission_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->renamePermission('manage_commission_users', 'manage_agents');
    }

    private function renamePermission(string $from, string $to): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->whereNotNull('permissions')
            ->get(['id', 'permissions'])
            ->each(function ($user) use ($from, $to) {
                $permissions = json_decode($user->permissions, true) ?: [];

                if (! in_array($from, $permissions)) {
                    return;
                }

                $permissions[array_search($from, $permissions)] = $to;

                DB::table('users')->where('id', $user->id)->update([
                    'permissions' => json_encode(array_values(array_unique($permissions))),
                ]);
            });
    }
};
