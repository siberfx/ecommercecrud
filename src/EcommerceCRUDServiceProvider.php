<?php

namespace SmartyStudio\EcommerceCrud;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class EcommerceCRUDServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/smartystudio/ecommercecrud.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupRoutes($this->app->router);

        // publish migrations
        $this->publishes([__DIR__ . '/database/migrations' => database_path('migrations')], 'migrations');

        // LOAD THE VIEWS
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/smartystudio/ecommercecrud'), 'smartystudio');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'smartystudio');

        // publish views
        $this->publishes([
            __DIR__ . '/resources/views/ecommercecrud' => resource_path('views/vendor/smartystudio/ecommercecrud'),
            __DIR__ . '/resources/views/backpack/crud' => resource_path('views/vendor/backpack/crud'),
            __DIR__ . '/resources/views/email/notification_template' => resource_path('views/vendor/smartystudio/ecommercecrud/email/notification_template'),
            __DIR__ . '/resources/views/renders' => resource_path('views/vendor/smartystudio/ecommercecrud/renders'),
        ], 'views');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // register its dependencies
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path() . $this->routeFilePath)) {
            $routeFilePathInUse = base_path() . $this->routeFilePath;
        }
        $this->loadRoutesFrom($routeFilePathInUse);
    }
}
