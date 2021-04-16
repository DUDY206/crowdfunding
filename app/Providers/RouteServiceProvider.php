<?php

namespace App\Providers;

use App\Http\Controllers\UploadImageController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        parent::boot();

        //map route subdomain from app config

        $route_config = json_decode(json_encode(config('app.subdomain')), FALSE);
        foreach ($route_config as $domain){
            foreach ($domain->route as $route => $config) {
                if ($route == 'route_web') {
                    Route::domain($domain->sub_domain.env('SITE_URL'))
                        ->middleware($config->middleware + ['shareSession'])
                        ->namespace($this->namespace)
                        ->as($domain->route_name_as)
                        ->group(base_path($config->base_path));
                } else {
                    // Route::domain('api-'.env('SITE_URL'))
                    Route::domain('api.'.env('SITE_URL'))
                        ->middleware($config->middleware + ['shareSession'])
                        ->prefix($config->prefix)
                        ->namespace($this->namespace)
                        // ->as('api-'.$domain->route_name_as)
                        ->as('api.'.$domain->route_name_as)
                        ->group(base_path($config->base_path));
                }
            }

        }

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
