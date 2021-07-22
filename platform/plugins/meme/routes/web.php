<?php

Route::group(['namespace' => 'Botble\Meme\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'memes', 'as' => 'meme.'], function () {
            Route::resource('', 'MemeController')->parameters(['' => 'meme']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'MemeController@deletes',
                'permission' => 'meme.destroy',
            ]);
        });
        //tag
        Route::group(['prefix' => 'meme-tags', 'as' => 'meme-tag.'], function () {
            Route::resource('', 'MemeTagController')->parameters(['' => 'meme-tag']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'MemeTagController@deletes',
                'permission' => 'meme-tag.destroy',
            ]);

            Route::get('tags/all', [
                'as' => 'all',
                'uses' => 'MemeTagController@getAllTags',
            ]);
        });

    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
            Route::get('search', [
                'as' => 'public.search',
                'uses' => 'PublicController@getSearch',
            ]);

            Route::get('/{page}', function($page) {
                return redirect()->route('public.index', ['p' => $page]);
            })->where('page', '^[0-9]+$');

            if (\SlugHelper::getPrefix(\Botble\Meme\Models\MemeTag::class, 'tag')) {
                Route::get(\SlugHelper::getPrefix(\Botble\Meme\Models\MemeTag::class, 'tag') . '/{slug}', [
                    'as' => 'public.meme_tag',
                    'uses' => 'PublicController@getTag',
                ]);
            }

            if (\SlugHelper::getPrefix(\Botble\Meme\Models\Meme::class, 'meme')) {
                Route::get(\SlugHelper::getPrefix(\Botble\Meme\Models\Meme::class, 'meme') . '/{slug}', [
                    'as' => 'public.meme',
                    'uses' => 'PublicController@getMeme',
                ]);
                Route::get(\SlugHelper::getPrefix(\Botble\Meme\Models\Meme::class, 'meme'), function() {
                    return redirect(url('/'));
                });
            }
        });
    }

});
