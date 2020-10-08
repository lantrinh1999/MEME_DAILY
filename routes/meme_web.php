<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Actions\Scaper\Crawler;
use App\Actions\Imgur\Imgur;
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

Route::get('/users', function () {
    return Inertia::render('Users/Index');
});
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});
Route::get('/crawler', function () {
    // $data = new Crawler();
    (new Crawler())->memehay(1);
});
Route::get('/imgur', function () {

    Imgur::uploadImage2('https://s.memehay.com/files/posts/20201008/khong-con-gi-trong-tim-ta-ca-nguc-bi-khoet-lo-ngay-tim-ded2c4208b689b92f9ee504b4e9e8307.jpg');
});