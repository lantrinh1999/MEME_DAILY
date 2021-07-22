<?php

namespace Botble\View\Providers;

use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\View\Models\View;
use Botble\View\Repositories\Caches\ViewCacheDecorator;
use Botble\View\Repositories\Eloquent\ViewRepository;
use Botble\View\Repositories\Interfaces\ViewInterface;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(ViewInterface::class, function () {
            return new ViewCacheDecorator(new ViewRepository(new View));
        });

        Helper::autoload(__DIR__ . '/../../helpers');

    }

    public function boot()
    {
        $this->app->register(EventServiceProvider::class);

        $this->setNamespace('plugins/view')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([View::class]);
            }

            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-view',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/view::view.name',
                'icon' => 'fa fa-list',
                'url' => route('view.index'),
                'permissions' => ['view.index'],
            ]);
        });

    }
}
