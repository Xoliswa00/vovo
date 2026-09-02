<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feature toggles
    |--------------------------------------------------------------------------
    |
    | Lightweight on/off switches for site sections that aren't ready to be
    | shown publicly yet. Flipping one to true (via the matching env var)
    | brings back its nav links and home-page section — no code change.
    |
    */

    // Public marketplace storefront: navbar + footer links and the
    // "Marketplace highlights" block on the home page. Admin/vendor product
    // management is unaffected and stays available in the dashboard.
    'marketplace' => env('FEATURE_MARKETPLACE', false),

];
