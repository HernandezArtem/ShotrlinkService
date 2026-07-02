<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        RateLimiter::for('link-creation', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            'original_url' => 'Слишком много запросов. Подождите минуту и попробуйте снова.',
                        ]);
                });
        });

        RateLimiter::for('link-redirect', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->ip())
                ->response(function () {
                    return response()->view('errors.too-many-requests', status: 429);
                });
        });

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
