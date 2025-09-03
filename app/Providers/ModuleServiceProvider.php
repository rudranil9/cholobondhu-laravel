<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadModuleRoutes();
        $this->loadModuleViews();
    }

    /**
     * Load routes from all modules
     */
    protected function loadModuleRoutes(): void
    {
        $modulesPath = base_path('Modules');
        
        if (File::exists($modulesPath)) {
            $modules = File::directories($modulesPath);
            
            foreach ($modules as $module) {
                $moduleName = basename($module);
                $routesPath = $module . '/Routes';
                
                if (File::exists($routesPath)) {
                    // Load web routes
                    $webRoutesFile = $routesPath . '/web.php';
                    if (File::exists($webRoutesFile)) {
                        Route::group([
                            'namespace' => "Modules\\{$moduleName}\\Controllers",
                            'prefix' => in_array(strtolower($moduleName), ['frontend', 'booking']) ? '' : strtolower($moduleName),
                            'middleware' => 'web'
                        ], function () use ($webRoutesFile) {
                            require $webRoutesFile;
                        });
                    }
                    
                    // Load API routes
                    $apiRoutesFile = $routesPath . '/api.php';
                    if (File::exists($apiRoutesFile)) {
                        Route::group([
                            'namespace' => "Modules\\{$moduleName}\\Controllers",
                            'prefix' => 'api/' . strtolower($moduleName),
                            'middleware' => 'api'
                        ], function () use ($apiRoutesFile) {
                            require $apiRoutesFile;
                        });
                    }
                }
            }
        }
    }

    /**
     * Load views from all modules
     */
    protected function loadModuleViews(): void
    {
        $modulesPath = base_path('Modules');
        
        if (File::exists($modulesPath)) {
            $modules = File::directories($modulesPath);
            
            foreach ($modules as $module) {
                $moduleName = basename($module);
                $viewsPath = $module . '/Views';
                
                if (File::exists($viewsPath)) {
                    $this->loadViewsFrom($viewsPath, strtolower($moduleName));
                }
            }
        }
    }
}
