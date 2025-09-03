<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Site Request Forgery (CSRF) Protection
    |--------------------------------------------------------------------------
    |
    | Laravel provides CSRF protection by default via middleware. This 
    | configuration allows you to customize various aspects of CSRF protection
    | including token expiration and cookie settings.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | CSRF Token Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that the CSRF token should
    | remain valid. By default, tokens remain valid for 2 hours (120 minutes).
    |
    */

    'lifetime' => env('CSRF_LIFETIME', 120),

    /*
    |--------------------------------------------------------------------------
    | CSRF Cookie Configuration
    |--------------------------------------------------------------------------
    |
    | These options determine how the CSRF token cookie is configured.
    | In production, ensure secure and httpOnly are true for security.
    |
    */

    'cookie' => [
        'name' => env('CSRF_COOKIE', 'XSRF-TOKEN'),
        'secure' => env('CSRF_COOKIE_SECURE', app()->environment('production')),
        'http_only' => env('CSRF_COOKIE_HTTP_ONLY', false),
        'same_site' => env('CSRF_COOKIE_SAME_SITE', 'lax'),
    ],

];
