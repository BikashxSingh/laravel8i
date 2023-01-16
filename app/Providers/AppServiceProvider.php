<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Product\ProductInterface;
use App\Repository\Product\ProductRepository;
use App\Repository\Category\CategoryInterface;
use App\Repository\Category\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
