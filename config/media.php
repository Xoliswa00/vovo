<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Upload path (filesystem)
    |--------------------------------------------------------------------------
    |
    | Absolute directory where uploaded images are written. Locally this is
    | the app's own public/assets/img. On hosts where the web document root
    | is a SEPARATE directory from the Laravel checkout (e.g. cPanel, where
    | the app sits in ~/repositories/app and the site is served from
    | ~/public_html), set MEDIA_UPLOAD_PATH to the document root's assets/img
    | so uploads are served immediately instead of only after a deploy sync.
    |
    |   MEDIA_UPLOAD_PATH=/home/<user>/public_html/assets/img
    |
    */

    'upload_path' => env('MEDIA_UPLOAD_PATH', public_path('assets/img')),

    /*
    |--------------------------------------------------------------------------
    | URL prefix (public)
    |--------------------------------------------------------------------------
    |
    | Public-relative prefix stored on each image row and resolved by asset().
    | This should match how the web server exposes the upload path above.
    | Almost always "assets/img" — only change it if the document root serves
    | the folder under a different URL.
    |
    */

    'url_prefix' => env('MEDIA_URL_PREFIX', 'assets/img'),

];
