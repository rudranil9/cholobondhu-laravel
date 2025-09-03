<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
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
        // $this->loadModuleRoutes();
        $this->loadModuleViews();
    }

    /**
     * Load module routes
     */
    protected function loadModuleRoutes(): void
    {
        $moduleConfigs = [
            'Frontend' => ['prefix' => ''],  // No prefix for frontend (public routes)
            'Booking' => ['prefix' => ''],   // No prefix for booking (already has /booking in routes)
            'Admin' => ['prefix' => 'admin'],
            'User' => ['prefix' => 'user'],
        ];
        
        foreach ($moduleConfigs as $module => $config) {
            $routePath = base_path("Modules/{$module}/Routes/web.php");
            if (file_exists($routePath)) {
                Route::middleware('web')
                    ->namespace("Modules\\{$module}\\Controllers")
                    ->prefix($config['prefix'])
                    ->group($routePath);
            }
        }
    }

    /**
     * Load module views
     */
    protected function loadModuleViews(): void
    {
        $modules = ['Frontend', 'Booking', 'Admin', 'User'];
        
        foreach ($modules as $module) {
            $viewPath = base_path("Modules/{$module}/Views");
            if (is_dir($viewPath)) {
                $this->loadViewsFrom($viewPath, strtolower($module));
            }
        }
    }
}
