<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind( 'App\Manager\UserManagerInterface',         'App\Manager\Eloquent\UserManager'         );
        $this->app->bind( 'App\Manager\TaskManagerInterface',         'App\Manager\Eloquent\TaskManager'         );
        $this->app->bind( 'App\Manager\CategoryManagerInterface',     'App\Manager\Eloquent\CategoryManager'     );
        $this->app->bind( 'App\Manager\ProductManagerInterface',      'App\Manager\Eloquent\ProductManager'      );
        $this->app->bind( 'App\Manager\TransactionManagerInterface',  'App\Manager\Eloquent\TransactionManager'  );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
