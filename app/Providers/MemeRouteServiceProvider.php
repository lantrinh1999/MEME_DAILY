<?php

namespace App\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MemeRouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        Route::middleware('web')
            ->group(base_path('routes/meme_web.php'));

        Route::prefix(config('meme.api_route', 'api'))
            ->middleware('api')
            ->group(base_path('routes/meme_api.php'));
    }
}