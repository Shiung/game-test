<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
            //後台route
            require app_path('Http/Routes/Admin/auth.php');
            require app_path('Http/Routes/Admin/content.php');
            require app_path('Http/Routes/Admin/member.php');
            require app_path('Http/Routes/Admin/system.php');
            require app_path('Http/Routes/Admin/upload.php');
            require app_path('Http/Routes/Admin/shop.php');
            require app_path('Http/Routes/Admin/game.php');
            require app_path('Http/Routes/Admin/statistic.php');
            require app_path('Http/Routes/Admin/download.php');
            //前台route
            require app_path('Http/Routes/Front/auth.php');
            require app_path('Http/Routes/Front/member.php');
            require app_path('Http/Routes/Front/content.php');
            require app_path('Http/Routes/Front/shop.php');
            require app_path('Http/Routes/Front/game.php');
            require app_path('Http/Routes/Front/sse.php');
        });
    }
}
