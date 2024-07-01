<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
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

        view()->composer(
            'layouts.frontend',
            function ($view) {
                $view->with('categories', Category::with('subCategories:id,name', 'products:id,title')->limit(10)->get());
            }
        );

        Paginator::defaultView('vendor.pagination.bootstrap-5');
    }
}
