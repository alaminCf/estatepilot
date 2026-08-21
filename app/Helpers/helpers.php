<?php

if (!function_exists('site_name')) {
    /**
     * Brand name of the platform, as configured in Admin > Settings > Branding.
     *
     * Falls back to the default brand when the setting is empty or the
     * database is not reachable yet (installs, migrations, console commands).
     *
     * @return string
     */
    function site_name() {
        static $name = null;

        if ($name !== null) {
            return $name;
        }

        $default = config('branding.site_name', 'Estate Pilot');

        try {
            $value = \App\Models\WebsiteSetting::get('site_name');
        } catch (\Throwable $e) {
            $value = null;
        }

        return $name = (is_string($value) && trim($value) !== '') ? trim($value) : $default;
    }
}

if (!function_exists('site_legal_name')) {
    /**
     * Full legal/registered name used on invoices, receipts and footers.
     * Defaults to the brand name with the configured legal suffix.
     *
     * @return string
     */
    function site_legal_name() {
        static $legalName = null;

        if ($legalName !== null) {
            return $legalName;
        }

        try {
            $value = \App\Models\WebsiteSetting::get('site_legal_name');
        } catch (\Throwable $e) {
            $value = null;
        }

        if (is_string($value) && trim($value) !== '') {
            return $legalName = trim($value);
        }

        return $legalName = trim(site_name() . ' ' . config('branding.legal_suffix', 'Ltd.'));
    }
}

if (!function_exists('site_tagline')) {
    /**
     * Short marketing tagline shown next to the brand name.
     *
     * @return string
     */
    function site_tagline() {
        static $tagline = null;

        if ($tagline !== null) {
            return $tagline;
        }

        $default = config('branding.tagline', 'Premium Real Estate Plots');

        try {
            $value = \App\Models\WebsiteSetting::get('site_tagline');
        } catch (\Throwable $e) {
            $value = null;
        }

        return $tagline = (is_string($value) && trim($value) !== '') ? trim($value) : $default;
    }
}

if (!function_exists('format_bd_number')) {
    /**
     * Format number in Bangladeshi/Indian numbering system
     * Example: 10,00,000 instead of 1,000,000
     * 
     * @param float $number
     * @param int $decimals
     * @return string
     */
    function format_bd_number($number, $decimals = 2) {
        $negative = $number < 0;
        $number = abs($number);
        
        $parts = explode('.', number_format($number, $decimals, '.', ''));
        $intPart = $parts[0];
        $decPart = isset($parts[1]) ? '.' . $parts[1] : '';
        
        // Remove decimal part if decimals = 0
        if ($decimals == 0) {
            $decPart = '';
        }
        
        $lastThree = substr($intPart, -3);
        $remaining = substr($intPart, 0, -3);
        
        if ($remaining != '') {
            $lastThree = ',' . $lastThree;
        }
        
        $formatted = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remaining) . $lastThree;
        
        return ($negative ? '-' : '') . $formatted . $decPart;
    }
}
