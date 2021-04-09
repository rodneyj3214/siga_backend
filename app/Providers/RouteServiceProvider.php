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
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

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

        $this->routes(function () {
            $this->mapApiRoutes();
//            Route::prefix('api')
//                ->middleware('api')
//                ->namespace($this->namespace)
//                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    protected function mapApiRoutes()
    {
        Route::prefix('v1/authentication')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/authentication/api.php'));

        Route::prefix('v1/attendance')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/attendance/api.php'));
        Route::prefix('v1/job_board')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/job_board/api.php'));
        Route::prefix('v1/cecy')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/cecy/api.php'));
        Route::prefix('v1/web')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/web/api.php'));
        Route::prefix('v1/app')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/app/api.php'));
        Route::prefix('v1/teacher_eval')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/teacher_eval/api.php'));
        Route::prefix('v1/community')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/community/api.php'));
        Route::prefix('v1/voting')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/voting/api.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(10000);
        });
    }
}
