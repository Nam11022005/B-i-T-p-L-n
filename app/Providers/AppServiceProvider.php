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

            $menuCategories = Category::query()
                ->select([
                    'id',
                    'name',
                ])
                ->with([
                    'products' => function ($query) {
                        $query
                            ->select([
                                'id',
                                'category_id',
                                'name',
                                'image',
                                'price',
                                'sale_price',
                                'sale_start',
                                'sale_end',
                            ])
                            ->orderBy('name', 'asc');
                    }
                ])
                ->orderBy('name', 'asc')
                ->get();

            $view->with(
                'menuCategories',
                $menuCategories
            );
        });
    }
}