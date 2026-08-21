<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Seed the branding settings so the brand name is editable from
     * Admin > Settings > Branding. Existing values are left untouched.
     */
    public function up(): void
    {
        $defaults = [
            'site_name' => 'Estate Pilot',
            'site_legal_name' => 'Estate Pilot Ltd.',
            'site_tagline' => 'Premium Real Estate Plots',
        ];

        foreach ($defaults as $key => $value) {
            $existing = DB::table('website_settings')->where('setting_key', $key)->first();

            if (!$existing) {
                DB::table('website_settings')->insert([
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'setting_group' => 'branding',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                continue;
            }

            // Key already existed (site_name was read but never written before);
            // move it into the branding group and fill it if it was blank.
            DB::table('website_settings')
                ->where('setting_key', $key)
                ->update([
                    'setting_value' => trim((string) $existing->setting_value) !== ''
                        ? $existing->setting_value
                        : $value,
                    'setting_group' => 'branding',
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('website_settings')
            ->whereIn('setting_key', ['site_name', 'site_legal_name', 'site_tagline'])
            ->delete();
    }
};
