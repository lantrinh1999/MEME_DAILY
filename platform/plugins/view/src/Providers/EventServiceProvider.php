<?php

namespace Botble\View\Providers;

use Botble\View\Events\ViewCountProcessed;
use Botble\View\Listeners\HandleViewCount;
use Botble\View\Models\View;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ViewCountProcessed::class => [
            HandleViewCount::class,
        ],
    ];

    public function register()
    {
        parent::register();
    }

    public function boot()
    {
        parent::boot();
    }
}
