<?php

namespace App\Providers;

use App\Models\Shop\Category;
use App\Repository\CategoryRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('include.top_menu', function ($view){
            $catalog_menu = CategoryRepository::getRootCategories();
            $view->with('catalog_menu', $catalog_menu);
        });
    }
}
