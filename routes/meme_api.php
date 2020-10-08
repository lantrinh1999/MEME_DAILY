<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Actions\Memevui\Memevui;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/crawler_memehay', function (Request $request) {
    (new Memevui())->run();
});
Route::get('/reset_page_memehay', function (Request $request) {
    (new Memevui())->resetPage();
});