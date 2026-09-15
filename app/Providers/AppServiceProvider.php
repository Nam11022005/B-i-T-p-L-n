<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('layouts.app', function ($view) {

            $menuCategories = Category::with([
                'products' => function ($query) {
                    $query->orderBy('name', 'asc');
                }
            ])
            ->orderBy('name', 'asc')
            ->get();

            $view->with('menuCategories', $menuCategories);
        });
    }
}