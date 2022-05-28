<?php

use App\Http\Controllers\Crawl;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Crawl\GetList::class)->name('index');

Route::group(['prefix' => 'crawl'], function() {

    Route::post('/', Crawl\Post::class);
    Route::group(['prefix' => '{crawlId}'], function () {
        Route::get('/', Crawl\Get::class);
    });
});
