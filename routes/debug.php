<?php

use Illuminate\Support\Facades\Route;

// Debug routes - remove after fixing
Route::get('/debug/assets', function () {
    $data = [
        'app_env' => app()->environment(),
        'app_debug' => config('app.debug'),
        'public_path' => public_path(),
        'build_path' => public_path('build'),
        'css_file_exists' => file_exists(public_path('build/assets/app-BCXFDP9b.css')),
        'js_file_exists' => file_exists(public_path('build/assets/app-DtCVKgHt.js')),
        'manifest_exists' => file_exists(public_path('build/manifest.json')),
        'build_contents' => is_dir(public_path('build')) ? scandir(public_path('build')) : 'Build directory not found',
        'assets_contents' => is_dir(public_path('build/assets')) ? scandir(public_path('build/assets')) : 'Assets directory not found',
    ];
    
    if (file_exists(public_path('build/manifest.json'))) {
        $data['manifest_content'] = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    }
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});

Route::get('/debug/css', function () {
    $cssPath = public_path('build/assets/app-BCXFDP9b.css');
    
    if (file_exists($cssPath)) {
        return response(file_get_contents($cssPath), 200, [
            'Content-Type' => 'text/css'
        ]);
    }
    
    return response('CSS file not found', 404);
});

Route::get('/debug/contact', function () {
    return response()->json([
        'contact_route_exists' => Route::has('contact.store'),
        'contact_route_url' => route('contact.store'),
        'mail_config' => [
            'driver' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host', 'Not set'),
            'port' => config('mail.mailers.smtp.port', 'Not set'),
            'username' => config('mail.mailers.smtp.username', 'Not set'),
            'encryption' => config('mail.mailers.smtp.encryption', 'Not set'),
            'from_address' => config('mail.from.address', 'Not set'),
            'from_name' => config('mail.from.name', 'Not set'),
        ],
        'env_vars' => [
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME') ? 'Set' : 'Not set',
            'MAIL_PASSWORD' => env('MAIL_PASSWORD') ? 'Set' : 'Not set',
        ]
    ], 200, [], JSON_PRETTY_PRINT);
});

Route::post('/debug/contact-test', function (\Illuminate\Http\Request $request) {
    try {
        $data = [
            'success' => true,
            'message' => 'Test contact form submission received',
            'received_data' => $request->all(),
            'csrf_token_valid' => true, // If we reach here, CSRF is valid
            'timestamp' => now()->toISOString(),
        ];
        
        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
