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
