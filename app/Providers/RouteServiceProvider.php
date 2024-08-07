<?php

namespace App\Providers;

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
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('administrador')
                ->group(base_path('routes/administrador.php'));

            Route::middleware('web')
                ->prefix('inscripcion')
                ->group(base_path('routes/inscripcion.php'));

            Route::middleware('web')
                ->prefix('plataforma')
                ->group(base_path('routes/plataforma.php'));

            Route::middleware('web')
                ->prefix('area-contable')
                ->group(base_path('routes/area-contable.php'));

            Route::middleware('web')
                ->prefix('coordinador')
                ->group(base_path('routes/coordinador.php'));

            Route::middleware('web')
                ->prefix('docente')
                ->group(base_path('routes/docente.php'));

            Route::middleware('web')
                ->prefix('evaluacion')
                ->group(base_path('routes/evaluacion.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
