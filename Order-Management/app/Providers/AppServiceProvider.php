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
        $workspaceRoot = realpath(dirname(__DIR__, 2) . '/..');

        $moduleViewPaths = [
            'grim' => $workspaceRoot . '/Goods-Receipt-Invoice-Matching/resources/views',
            'orders' => $workspaceRoot . '/Order-Management/resources/views',
            'requisitions' => $workspaceRoot . '/Purchase-and-Requisition/resources/views',
            'suppliers' => $workspaceRoot . '/Supplier-Management/resources/views',
        ];

        foreach ($moduleViewPaths as $namespace => $path) {
            View::addNamespace($namespace, realpath($path) ?: $path);
        }
    }
}
