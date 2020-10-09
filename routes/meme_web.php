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
Route::group(['prefix' => $adminRoute,'namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth'], function () {
    Route::get( '/',  function (){
        return Inertia::render('Users/Index');
        })->name('admin');

    Route::group(['prefix' => 'users',], function () {
        Route::get('/', 'UserController@index')->name('users.index');
        Route::get('create', 'UserController@create')->name('users.create');
        Route::post('store', 'UserController@store')->name('users.store');
        Route::get('{id}/edit', 'UserController@edit')->name('users.edit');
        Route::put('{id}', 'UserController@update')->name('users.update');
        Route::post('destroy', 'UserController@destroy')->name('users.destroy');
        Route::post('trashed', 'UserController@trashed')->name('users.trashed');
        Route::post('restore', 'UserController@restore')->name('users.restore');
    });
});



Route::get('/users', function () {
    dd(\Illuminate\Support\Facades\Auth::check());
    return Inertia::render('Users/Index');
})->middleware('auth');

