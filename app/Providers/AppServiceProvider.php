<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $moduleViewPaths = [
            'grim' => resource_path('views/grim'),
            'orders' => resource_path('views'),
            'requisitions' => resource_path('views/requisitions'),
            'suppliers' => resource_path('views/suppliers'),
        ];

        foreach ($moduleViewPaths as $namespace => $path) {
            View::addNamespace($namespace, $path);
        }
    }
}
