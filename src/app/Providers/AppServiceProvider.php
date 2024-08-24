<?php

namespace App\Providers;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
        Paginator::useBootstrap();

        // Share categories with all views
        View::composer('*', function ($view) {
            $categories = ProductCategory::select('name')->get();
            $view->with('categories', $categories);

            // Share user data with all views
            $user = User::where('id', Auth::id())->first();
            $view->with('user', $user);
        });
    }
}
