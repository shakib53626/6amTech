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
        $this->app->bind( 'App\Manager\UserManagerInterface',     'App\Manager\Eloquent\UserManager'     );
        $this->app->bind( 'App\Manager\TaskManagerInterface',     'App\Manager\Eloquent\TaskManager'     );
        $this->app->bind( 'App\Manager\CategoryManagerInterface', 'App\Manager\Eloquent\CategoryManager' );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
