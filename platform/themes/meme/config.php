<?php

use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
     */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
     */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function ($theme) {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme) {
            $version = \Str::random(10);
            $version = md5(date('m') . '-123');
            // Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });

            // You may use this event to set up your assets.
            $theme->asset()
                ->usePath()->add('bootstrap-css', 'css/bootstrap.min.css')
                ->usePath()->add('font-awesome-css', 'fonts/fontawesome/css/all.min.css')
                ->usePath()->add('style-css', 'css/style.css', [], [], $version)
            ;

            $theme->asset()->container('footer')
                ->usePath()->add('jquery', 'js/jquery-3.6.0.min.js')
                ->usePath()->add('bootstrap-js', 'js/bootstrap.bundle.min.js', ['jquery'], [], $version);
            if (Agent::isDesktop()) {
                $theme->asset()->container('footer')->usePath()->add('masonry-js', 'js/masonry.pkgd.min.js', ['jquery'], [], $version);
            }

            $theme->asset()->container('footer')->usePath()->add('imagesloaded-js', 'js/imagesloaded.pkgd.min.js', ['jquery'], [], $version)
                ->usePath()->add('script', 'js/script.js', ['jquery'], [], $version)
            ;

            // if (function_exists('shortcode')) {
            //     $theme->composer(['index', 'page', 'post'], function (\Botble\Shortcode\View\View $view) {
            //         $view->withShortcodes();
            //     });
            // }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function ($theme) {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            },
        ]
    ]
];
