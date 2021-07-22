<?php

namespace Botble\Meme\Providers;

use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Meme\Models\Meme;
use Botble\Meme\Repositories\Caches\MemeCacheDecorator;
use Botble\Meme\Repositories\Eloquent\MemeRepository;
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class MemeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(MemeInterface::class, function () {
            return new MemeCacheDecorator(new MemeRepository(new Meme));
        });

        // tag
        $this->app->bind(\Botble\Meme\Repositories\Interfaces\MemeTagInterface::class, function () {
            return new \Botble\Meme\Repositories\Caches\MemeTagCacheDecorator(
                new \Botble\Meme\Repositories\Eloquent\MemeTagRepository(new \Botble\Meme\Models\MemeTag)
            );
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }

        $this->commands([
            \Botble\Meme\Console\Commands\CrawlMemehay::class,
            \Botble\Meme\Console\Commands\WebpToJpg::class,
        ]);
        \SlugHelper::registerModule(\Botble\Meme\Models\Meme::class, 'Meme');
        \SlugHelper::registerModule(\Botble\Meme\Models\MemeTag::class, 'Meme Tags');

        \SlugHelper::setPrefix(\Botble\Meme\Models\MemeTag::class, 'tag');
        \SlugHelper::setPrefix(\Botble\Meme\Models\Meme::class, 'meme');

        $this->setNamespace('plugins/meme')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-meme',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'Meme',
                'icon' => 'fas fa-smile',
                'url' => route('meme.index'),
                'permissions' => ['meme.index'],
            ]);
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-meme-list',
                'priority' => 0,
                'parent_id' => 'cms-plugins-meme',
                'name' => 'Danh sách',
                'icon' => '',
                'url' => route('meme.index'),
                'permissions' => ['meme.index'],
            ]);
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-meme-tag',
                'priority' => 0,
                'parent_id' => 'cms-plugins-meme',
                'name' => 'Tag',
                'icon' => null,
                'url' => route('meme-tag.index'),
                'permissions' => ['meme-tag.index'],
            ]);
        });

        $this->app->booted(function () {
            $models = [\Botble\Meme\Models\MemeTag::class, \Botble\Meme\Models\Meme::class];

            \SeoHelper::registerModule($models);

            // $this->app->register(HookServiceProvider::class);

            $schedule = $this->app->make(Schedule::class);
            $schedule->command('crawl:memehay --page=10')
            // ->everyMinute()
            // ->everySixHours()
            ->runInBackground()
            ->everyTwoHours()
            ->onSuccess(function () {
                \Log::info("Crawler Memehay OK!");
            })
            ->onFailure(function () {
                \Log::error("Crawler ERROR!!!");
            });
            ;

        });

        $this->siteMap();
    }

    private function siteMap()
    {
        \Event::listen(\Botble\Theme\Events\RenderingSiteMapEvent::class, function () {
            // \SiteMapManager::add('', date('Y-d-01 00:00:00'), '0.8', 'monthly');
            // Add many URLs

            $memes = app(MemeInterface::class)->getDataSiteMap();
            foreach ($memes as $meme) {
                \SiteMapManager::add($meme->url, $meme->updated_at, '0.8', 'daily');
                \SiteMapManager::add(route('public.single', ['s' => $meme->name]), $meme->updated_at, '0.8', 'daily');
            }

            $tags = app(\Botble\Meme\Repositories\Interfaces\MemeTagInterface::class)->getDataSiteMap();
            foreach ($tags as $tag) {
                \SiteMapManager::add($tag->url, $tag->updated_at, '0.8', 'daily');
                \SiteMapManager::add(route('public.single', ['s' => $tag->name]), $tag->updated_at, '0.8', 'daily');
            }



        });
    }
}
