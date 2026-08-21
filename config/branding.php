<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Branding Fallbacks
    |--------------------------------------------------------------------------
    |
    | These values are used by the site_name(), site_legal_name() and
    | site_tagline() helpers whenever the matching setting in
    | Admin > Settings > Branding has not been filled in (or the database
    | is not yet reachable, e.g. during installation).
    |
    */

    'site_name' => env('BRAND_NAME', 'Estate Pilot'),

    'legal_suffix' => env('BRAND_LEGAL_SUFFIX', 'Ltd.'),

    'tagline' => env('BRAND_TAGLINE', 'Premium Real Estate Plots'),

];
