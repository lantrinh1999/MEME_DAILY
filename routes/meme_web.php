<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Actions\Scaper\Crawler;
use App\Actions\Imgur\Imgur;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$adminRoute = config('meme.admin_url', 'admin_');
/**
 * Auth routes
 */
Route::group([
    'namespace' => 'App\Http\Controllers\Auth',
//    'prefix' => $adminRoute
], function () use ($adminRoute) {
    Route::get('login', ['uses' => 'LoginController@showAdminLoginForm'])->name('login');
    Route::post('login', ['uses' => 'LoginController@login'])->name('login.attempt');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Auth',
], function () use ($adminRoute) {
    Route::get('logout', 'LoginController@logout')->name('logout');
});


// admin module
Route::group(['prefix' => $adminRoute, 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth'], function () {
    Route::get('/', function () {
        return Inertia::render('Users/Index');
    })->name('admin');

    Route::group(['prefix' => 'users',], function () {
        Route::get('/', [
            'as' => 'users.index',
            'uses' => 'UserController@index',
            'permission' => 'users.index',
            'menu' => ['parent_name' => 'Users', 'name' => 'List Users' ,'priority' => '3', 'icon' => 'fa fa-user', 'parent' => null],
        ]);
        Route::get('create', [
            'as' => 'users.create',
            'uses' => 'UserController@create',
            'permission' => 'users.create',
            'menu' => ['name' => 'Create Users', 'priority' => '3', 'icon' => ' fa fa-plus', 'parent' => 'users.index'],

        ]);
        Route::post('store', [
            'as' => 'users.store',
            'uses' => 'UserController@store',
            'permission' => ['users.create'],
        ]);
        Route::get('{id}/edit', [
            'as' => 'users.edit',
            'uses' => 'UserController@edit',
            'permission' => ['users.edit']
        ]);
        Route::put('{id}', [
            'as' => 'users.update',
            'uses' => 'UserController@update',
            'permission' => ['users.edit']
        ]);
        Route::post('destroy', [
            'as' => 'users.destroy',
            'uses' => 'UserController@destroy',
            'permission' => ['users.destroy']
        ]);
        Route::post('trashed', [
            'as' => 'users.trashed',
            'uses' => 'UserController@trashed',
            'permission' => ['users.destroy']
        ]);
        Route::post('restore', [
            'as' => 'users.restore',
            'uses' => 'UserController@restore',
            'permission' => ['users.destroy']
        ]);
    });

    Route::group(['prefix' => 'memes',], function () {
        Route::get('/', [
            'as' => 'memes.index',
            'uses' => 'MemeController@index',
            'permission' => 'memes.index',
            'menu' => ['parent_name' => 'Memes', 'name' => 'List Memes' ,'priority' => '1', 'icon' => 'far fa-grin-alt', 'parent' => null],
        ]);
        Route::get('create', [
            'as' => 'memes.create',
            'uses' => 'MemeController@create',
            'permission' => 'memes.create',
            'menu' => ['name' => 'Create Memes', 'priority' => '3', 'icon' => ' fa fa-plus', 'parent' => 'memes.index'],

        ]);
        Route::post('store', [
            'as' => 'memes.store',
            'uses' => 'MemeController@store',
            'permission' => ['memes.create'],
        ]);
        Route::get('{id}/edit', [
            'as' => 'memes.edit',
            'uses' => 'MemeController@edit',
            'permission' => ['memes.edit']
        ]);
        Route::put('{id}', [
            'as' => 'memes.update',
            'uses' => 'MemeController@update',
            'permission' => ['memes.edit']
        ]);
        Route::post('destroy', [
            'as' => 'memes.destroy',
            'uses' => 'MemeController@destroy',
            'permission' => ['memes.destroy']
        ]);
        Route::post('trashed', [
            'as' => 'memes.trashed',
            'uses' => 'MemeController@trashed',
            'permission' => ['memes.destroy']
        ]);
        Route::post('restore', [
            'as' => 'memes.restore',
            'uses' => 'UserController@restore',
            'permission' => ['memes.destroy']
        ]);
    });
});



//THEME

Route::group([
    'namespace' => 'App\Http\Controllers',
], function ()  {
    Route::get('/{page?}', ['uses' => 'ThemeController@index'])->name('theme.home');
});
