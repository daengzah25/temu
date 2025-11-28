<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Helper function untuk mendapatkan asset dari manifest atau fallback
        if (!function_exists('vite_asset')) {
            function vite_asset(string $resource, ?string $fallback = null): string
            {
                $manifestPath = public_path('build/manifest.json');
                
                if (file_exists($manifestPath)) {
                    $manifest = json_decode(file_get_contents($manifestPath), true);
                    
                    if (isset($manifest[$resource]['file'])) {
                        return asset('build/' . $manifest[$resource]['file']);
                    }
                }
                
                // Fallback ke asset langsung jika manifest tidak ada
                if ($fallback) {
                    return asset($fallback);
                }
                
                // Fallback default berdasarkan resource
                if (str_contains($resource, 'css')) {
                    return asset('build/assets/app.css');
                }
                
                if (str_contains($resource, 'js')) {
                    return asset('build/assets/app.js');
                }
                
                return asset('build/' . basename($resource));
            }
        }
    }
}
