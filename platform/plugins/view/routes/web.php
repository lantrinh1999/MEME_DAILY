<?php

Route::group(['namespace' => 'Botble\View\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'views', 'as' => 'view.'], function () {
            Route::resource('', 'ViewController')->parameters(['' => 'view']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ViewController@deletes',
                'permission' => 'view.destroy',
            ]);
        });
    });

});
