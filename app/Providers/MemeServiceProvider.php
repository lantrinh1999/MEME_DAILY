<?php

namespace App\Providers;

use App\Http\Middleware\MemeAuthenticate;
use App\Http\Middleware\MemeRedirectIfAuthenticated;
use App\Models\User;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Middleware\AuthenticateSession;
use League\Glide\Server;
use Illuminate\Support\Facades\Cache;

class MemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    protected $menu;

    public function register()
    {
        // dd('aa');
        $this->app->register(MemeRouteServiceProvider::class);
        $this->setRootViewInertia();
        $this->registerInertia();
        $this->registerGlide();
        $this->registerLengthAwarePaginator();


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        parent::boot();
        $this->middlewareRegister();

    }

    protected function overrideConfig()
    {
        config(['database.connections.mysql.prefix' => env('DB_PREFIX', 'meme_')]);
        config(['database.connections.mysql.prefix_indexes' => true]);
        config(['auth.providers.users.model' => User::class]);
    }

    protected function middlewareRegister()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth', MemeAuthenticate::class);
        $router->aliasMiddleware('guest', MemeRedirectIfAuthenticated::class);
        $router->pushMiddlewareToGroup('web', AuthenticateSession::class);
    }

    public function setRootViewInertia()
    {
        Inertia::setRootView('app');
    }


    public function registerInertia()
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Route::matched(function () {
            Inertia::share([
                'auth' => function () {
                    return [
                        'user' => Auth::user() ? [
                            'id' => Auth::user()->id,
                            'first_name' => Auth::user()->first_name,
                            'last_name' => Auth::user()->last_name,
                            'email' => Auth::user()->email,
                        ] : null,
                    ];
                },
                'currentUrl' => function () {
                    try {
                       return route(Route::currentRouteName());
                    } catch (\Exception $e) {
                        return url('/ ');
                    }
                },
                'flash' => function () {
                    return [
                        'success' => Session::get('success'),
                        'error' => Session::get('error'),
                    ];
                },
                'menu' => function () {
                    return $this->adminMenu();
                }
            ]);
        });

    }

    protected function adminMenu()
    {
        $menu = Cache::store('file')->get('admin_menu');
        if (empty($menu)) {
            $menuData = collect(Route::getRoutes())->filter(function ($route) {
                return !empty($route->action['menu']);
            })->map(function ($route) {
                $_menu = $route->action['menu'];
                $_menu['key'] = $route->action['as'];
                $_menu['url'] = route($route->action['as']);
                $_menu['permission'] = $route->action['permission'];
                return $_menu;
            })->sortBy('priority')->toArray();
            function buildTree(array &$menuData, $parentId = null)
            {
                $menu = array();
                foreach ($menuData as $element) {
                    if ($element['parent'] == $parentId) {
                        $children = buildTree($menuData, $element['key']);
                        if ($children) {
                            $element['children'] = $children;
                        }
                        $menu[$element['key']] = $element;
                    }
                }
                return $menu;
            }

            $menu = buildTree($menuData);
            Cache::store('file')->forever('admin_menu', $menu);
        }
        return $menu;
    }

    protected function menuFunc($menuData, $parent = null)
    {
        foreach ($menuData as $key => $item) {
            if ($item['parent'] == $parent) {

                $this->menu[] = $item;
                unset($menuData[$key]);
                $this->menuFunc($menuData, $item['key']);
            }
        }
        return $this->menu;
    }

    protected function registerGlide()
    {
        $this->app->bind(Server::class, function ($app) {
            return Server::create([
                'source' => Storage::getDriver(),
                'cache' => Storage::getDriver(),
                'cache_folder' => '.glide-cache',
                'base_url' => 'img',
            ]);
        });
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class (...array_values($values)) extends LengthAwarePaginator {
                /**
                 * @param mixed ...$attributes
                 * @return $this
                 */
                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function toArray()
                {
                    return [
                        'data' => $this->items->toArray(),
                        'links' => $this->links(),
                    ];
                }

                public function links($view = null, $data = [])
                {
                    $this->appends(Request::all());

                    $window = UrlWindow::make($this);

                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);

                    return Collection::make($elements)->flatMap(function ($item) {
                        if (is_array($item)) {
                            return Collection::make($item)->map(function ($url, $page) {
                                return [
                                    'url' => $url,
                                    'label' => $page,
                                    'active' => $this->currentPage() === $page,
                                ];
                            });
                        } else {
                            return [
                                [
                                    'url' => null,
                                    'label' => '...',
                                    'active' => false,
                                ],
                            ];
                        }
                    })->prepend([
                        'url' => $this->previousPageUrl(),
                        'label' => 'Previous',
                        'active' => false,
                    ])->push([
                        'url' => $this->nextPageUrl(),
                        'label' => 'Next',
                        'active' => false,
                    ]);
                }
            };
        });
    }
}
