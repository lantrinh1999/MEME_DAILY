const cssImport = require("postcss-import");
const cssNesting = require("postcss-nesting");
const mix = require("laravel-mix");
const path = require("path");
const purgecss = require("@fullhuman/postcss-purgecss");
// const tailwindcss = require('tailwindcss')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/**
 * ADMIN
 */
const admin_assets = "resources/assets/admin/";
mix.js("resources/js/admin/app.js", "public/admin/js")
    .scripts(
        [
            admin_assets + "plugins/jquery/jquery.min.js",
            admin_assets + "plugins/jquery-ui/jquery-ui.min.js",
            admin_assets + "plugins/bootstrap/js/bootstrap.bundle.min.js",
            admin_assets + "plugins/chart.js/Chart.min.js",
            admin_assets + "plugins/sparklines/sparkline.js",
            admin_assets + "plugins/jqvmap/jquery.vmap.min.js",
            admin_assets + "plugins/jqvmap/maps/jquery.vmap.usa.js",
            admin_assets + "plugins/jquery-knob/jquery.knob.min.js",
            admin_assets + "plugins/moment/moment.min.js",
            admin_assets + "plugins/daterangepicker/daterangepicker.js",
            admin_assets +
                "plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js",
            admin_assets + "plugins/summernote/summernote-bs4.min.js",
            admin_assets +
                "plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
            admin_assets + "dist/js/adminlte.js",
        ],
        "public/admin/js/scripts.js"
    )
    .styles(
        [
            // admin_assets + 'plugins/fontawesome-free/css/all.min.css',
            admin_assets +
                "plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css",
            admin_assets + "plugins/icheck-bootstrap/icheck-bootstrap.min.css",
            admin_assets + "plugins/jqvmap/jqvmap.min.css",
            admin_assets + "dist/css/adminlte.min.css",
            admin_assets +
                "plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
            admin_assets + "plugins/daterangepicker/daterangepicker.css",
            admin_assets + "plugins/daterangepicker/daterangepicker.css",
            admin_assets + "plugins/summernote/summernote-bs4.css",
            admin_assets + "dist/icons/icomoon/styles.min.css",
        ],
        "public/admin/css/style.css"
    )
    .copyDirectory(
        admin_assets + "dist/icons/icomoon/fonts",
        "public/admin/css/fonts"
    )
    .options({
        postCss: [
            cssImport(),
            cssNesting(),
            // tailwindcss('tailwind.config.js'),
            ...(mix.inProduction()
                ? [
                      purgecss({
                          content: [
                              "./resources/views/**/*.blade.php",
                              "./resources/js/**/*.vue",
                          ],
                          defaultExtractor: (content) =>
                              content.match(/[\w-/:.]+(?<!:)/g) || [],
                          whitelistPatternsChildren: [/nprogress/],
                      }),
                  ]
                : []),
        ],
    })
    .webpackConfig({
        output: { chunkFilename: "js/admin/[name].js?id=[chunkhash]" },
        resolve: {
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
                "@": path.resolve("resources/js"),
            },
        },
    })
    .version()
    .sourceMaps();
