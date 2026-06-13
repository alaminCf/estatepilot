<?php

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
